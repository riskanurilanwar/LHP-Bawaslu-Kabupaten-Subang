<?php

namespace App\Controllers;

use App\Models\PenugasanModel;
use App\Models\UserModel;

class KelolaPenugasan extends BaseController
{
    private const TAHAPAN_OPTIONS = [
        'PENYUSUNAN PERATURAN KPU',
        'PEMUTAKHIRAN DATA PEMILIH DAN PEMILIHAN DAFTAR PEMILIIH',
        'PENDAFTARAN DAN VERIFIKASI PESERTA PEMILU',
        'PENETAPAN PESERTA PEMILU',
        'MASA KAMPANYE PEMILU',
        'PENCALONAN',
        'PENETAPAN JUMLAH KURSI DAN PENETAPAN DAPIL',
        'MASA TENANG',
        'PEMUNGUTAN DAN PENGHITUNGAN SUARA',
        'PENETAPAN HASIL PEMILU',
        'PENGUCAPAN SUMPAH/JANJI',
        'LAINNYA',
    ];

    public function index()
    {
        $db = db_connect();
        $penugasan = $db->table('penugasan')
            ->select('penugasan.id, penugasan.pengawas_id, penugasan.wilayah, penugasan.tahapan, penugasan.created_at, users.nama AS nama_pengguna, users.role AS role_pengguna')
            ->join('users', 'users.id = penugasan.pengawas_id')
            ->orderBy('penugasan.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $pengguna = (new UserModel())
            ->select('id, nama, role, is_active')
            ->where('is_active', 1)
            ->orderBy('nama', 'ASC')
            ->findAll();
        $editingAssignment = null;
        $editingAssignmentHasLhp = false;
        $editId = filter_var(
            $this->request->getGet('edit'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if ($editId !== false) {
            $editingAssignment = $db->table('penugasan')
                ->where('id', $editId)
                ->get()
                ->getRowArray();

            if ($editingAssignment === null) {
                return redirect()->to('/kelola-penugasan')
                    ->with('error', 'Penugasan tidak ditemukan.');
            }

            $editingAssignmentHasLhp = $db->table('lhp')
                ->where('assignment_id', $editId)
                ->countAllResults() > 0;

            $currentUser = (new UserModel())->find($editingAssignment['pengawas_id']);
            if ($currentUser !== null && ! in_array(
                (int) $currentUser['id'],
                array_map('intval', array_column($pengguna, 'id')),
                true
            )) {
                $pengguna[] = $currentUser;
            }
        }

        return view('penugasan/index', [
            'title'             => 'Kelola Penugasan',
            'penugasan'         => $penugasan,
            'pengguna'          => $pengguna,
            'tahapanOptions'    => self::TAHAPAN_OPTIONS,
            'editingAssignment' => $editingAssignment,
            'editingAssignmentHasLhp' => $editingAssignmentHasLhp,
        ]);
    }

    public function store()
    {
        $wilayahInput = $this->request->getPost('wilayah');
        $tahapanInput = $this->request->getPost('tahapan');
        $wilayah = is_string($wilayahInput) ? trim($wilayahInput) : '';
        $tahapan = is_string($tahapanInput) ? trim($tahapanInput) : '';

        if ($wilayah === '' || $tahapan === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Wilayah dan tahapan wajib diisi.');
        }

        if (! in_array($tahapan, self::TAHAPAN_OPTIONS, true)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih tahapan pengawasan yang tersedia.');
        }

        $rules = [
            'wilayah' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $selectedUsers = $this->request->getPost('pengguna_ids');
        if (!is_array($selectedUsers) || $selectedUsers === []) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih setidaknya satu pengguna untuk penugasan.');
        }

        $userIds = [];
        foreach ($selectedUsers as $selectedUser) {
            $userId = filter_var(
                $selectedUser,
                FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 1]]
            );
            if ($userId === false) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pilihan pengguna tidak valid.');
            }

            $userIds[] = $userId;
        }
        $userIds = array_values(array_unique($userIds));

        $penggunaAktif = (new UserModel())
            ->select('id')
            ->whereIn('id', $userIds)
            ->where('is_active', 1)
            ->findAll();
        $activeUserIds = array_map('intval', array_column($penggunaAktif, 'id'));

        if (count($activeUserIds) !== count($userIds)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Satu atau beberapa pengguna tidak ditemukan atau tidak aktif.');
        }

        $db = db_connect();
        $penugasanModel = new PenugasanModel();
        $db->transBegin();

        foreach ($userIds as $userId) {
            $saved = $penugasanModel->insert([
                'pengawas_id' => $userId,
                'wilayah' => $wilayah,
                'tahapan' => $tahapan,
                'created_by' => session()->get('user_id'),
            ]);

            if ($saved === false) {
                $db->transRollback();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Penugasan gagal disimpan.');
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Penugasan gagal disimpan.');
        }

        $db->transCommit();

        return redirect()->to('/kelola-penugasan')
            ->with('success', 'Penugasan berhasil diberikan kepada ' . count($userIds) . ' pengguna.');
    }

    public function update(int $id)
    {
        $penugasanModel = new PenugasanModel();
        $assignment = $penugasanModel->find($id);

        if ($assignment === null) {
            return redirect()->to('/kelola-penugasan')
                ->with('error', 'Penugasan tidak ditemukan.');
        }

        $userId = filter_var(
            $this->request->getPost('pengawas_id'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );
        $wilayahInput = $this->request->getPost('wilayah');
        $tahapanInput = $this->request->getPost('tahapan');
        $wilayah = is_string($wilayahInput) ? trim($wilayahInput) : '';
        $tahapan = is_string($tahapanInput) ? trim($tahapanInput) : '';
        $redirectUrl = '/kelola-penugasan?edit=' . $id;

        if ($userId === false || $wilayah === '' || ! in_array($tahapan, self::TAHAPAN_OPTIONS, true)) {
            return redirect()->to($redirectUrl)
                ->withInput()
                ->with('error', 'Pengguna, wilayah, dan tahapan yang valid wajib dipilih.');
        }

        if ($userId !== (int) $assignment['pengawas_id']
            && db_connect()->table('lhp')->where('assignment_id', $id)->countAllResults() > 0) {
            return redirect()->to($redirectUrl)
                ->withInput()
                ->with('error', 'Pengguna tidak dapat diubah karena penugasan ini sudah memiliki LHP.');
        }

        if (! $this->validate(['wilayah' => 'required|max_length[100]'])) {
            return redirect()->to($redirectUrl)
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userId === (int) $assignment['pengawas_id']
            ? $userModel->find($userId)
            : $userModel
                ->where('id', $userId)
                ->where('is_active', 1)
                ->first();

        if ($user === null) {
            return redirect()->to($redirectUrl)
                ->withInput()
                ->with('error', 'Pilih akun pengguna yang aktif.');
        }

        if (! $penugasanModel->update($id, [
            'pengawas_id' => $userId,
            'wilayah'     => $wilayah,
            'tahapan'     => $tahapan,
        ])) {
            return redirect()->to($redirectUrl)
                ->withInput()
                ->with('error', 'Penugasan gagal diperbarui.');
        }

        return redirect()->to('/kelola-penugasan')
            ->with('success', 'Penugasan berhasil diperbarui.');
    }
}
