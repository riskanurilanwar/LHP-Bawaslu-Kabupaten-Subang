<?php

namespace App\Controllers;

use App\Models\LhpModel;

class MonitoringLhp extends BaseController
{
    protected $lhpModel;

    public function __construct()
    {
        $this->lhpModel = new LhpModel();
    }

    public function index()
    {
        $role = session()->get('role');

        // Monitoring hanya untuk Admin dan Pimpinan
        if (!in_array($role, ['admin', 'pimpinan'], true)) {
            return redirect()->to(base_url('lhp'))
                ->with('error', 'Anda tidak memiliki akses monitoring.');
        }

        $keyword = trim((string) $this->request->getGet('keyword'));
        $builder = $this->lhpModel
            ->orderBy('created_at', 'DESC');

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('nomor_lhp', $keyword)
                ->orLike('nama_pengawas', $keyword)
                ->orLike('kecamatan', $keyword)
                ->orLike('desa', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Monitoring LHP',
            'lhp'   => $builder->paginate(10),
            'pager' => $this->lhpModel->pager,
        ];

        return view('monitoring/index', $data);
    }

    public function updateStatus($id)
    {
        $role = strtolower(session()->get('role'));

        if (! in_array($role, ['admin', 'pimpinan'])) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki hak untuk memeriksa LHP.');
        }

        $lhp = $this->lhpModel->find($id);

        if (! $lhp) {
            return redirect()->to('/monitoring-lhp')
                ->with('error', 'Data LHP tidak ditemukan.');
        }

        $rules = [
            'status_pemeriksaan' => [
                'rules' => 'required|in_list[Diperiksa,Perlu Perbaikan]',
                'errors' => [
                    'required' => 'Status pemeriksaan harus dipilih.',
                    'in_list' => 'Status pemeriksaan tidak valid.',
                ],
            ],
            'catatan_pimpinan' => [
                'rules' => 'permit_empty|max_length[2000]',
                'errors' => [
                    'max_length' => 'Catatan maksimal 2000 karakter.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $status = $this->request->getPost('status_pemeriksaan');
        $catatan = trim((string) $this->request->getPost('catatan_pimpinan'));

        if ($status === 'Perlu Perbaikan' && $catatan === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Catatan wajib diisi jika LHP perlu diperbaiki.');
        }

        $this->lhpModel->update($id, [
            'status_pemeriksaan' => $status,
            'catatan_pimpinan'   => $catatan ?: null,
            'diperiksa_oleh'     => session()->get('id'),
            'diperiksa_pada'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/lhp/detail/' . $id)
            ->with('success', 'Hasil pemeriksaan berhasil disimpan.');
    }
}