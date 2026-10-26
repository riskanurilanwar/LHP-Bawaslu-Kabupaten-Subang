<?php

namespace App\Controllers;

use App\Models\LhpModel;
use App\Models\LhpLampiranModel;
use App\Models\LhpDocumentTemplateModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class Lhp extends BaseController
{
    protected LhpModel $lhpModel;
    protected LhpLampiranModel $lampiranModel;

    public function __construct()
    {
        $this->lhpModel = new LhpModel();
        $this->lampiranModel = new LhpLampiranModel();
    }

    /**
     * Daftar LHP.
     * Pengawas hanya melihat LHP miliknya.
     * Admin dan Pimpinan melihat seluruh LHP.
     */
    public function index()
    {
        $role   = session()->get('role');
        $userId = session()->get('user_id');
        $keyword = trim((string) $this->request->getGet('keyword'));

        $builder = $this->lhpModel
            ->select('lhp.*')
            ->orderBy('lhp.created_at', 'DESC');

        // Hak akses Staff/Pengawas
        if (in_array($role, ['pengawas', 'staff'], true)) {
            $builder->where('lhp.user_id', $userId);
        }

        // Pencarian
        if ($keyword !== '') {
            $builder->groupStart()
                ->like('nomor_lhp', $keyword)
                ->orLike('desa', $keyword)
                ->orLike('kecamatan', $keyword)
                ->orLike('nama_pengawas', $keyword)
                ->groupEnd();
        }

        $data = [
            'title' => 'Daftar LHP',
            'lhp'   => $builder->paginate(10),
            'pager' => $this->lhpModel->pager,
        ];

        return view('lhp/index', $data);
    }

    /**
     * Menampilkan Form A.
     */
    public function create()
    {
        if (! in_array(session()->get('role'), ['pengawas', 'admin', 'pimpinan'], true)) {
            return redirect()->to('/dashboard/' . session()->get('role'))
                ->with('error', 'Anda tidak memiliki akses untuk membuat LHP.');
        }

        return view('lhp/form', [
            'title' => 'Tambah LHP',
            'lhp'   => [],
        ]);
    }

    /**
     * Menyimpan LHP baru dan foto bukti.
     */
    public function store()
    {
        if (! in_array(session()->get('role'), ['pengawas', 'admin', 'pimpinan'], true)) {
            return redirect()->to('/lhp')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $rules = [
            'tahapan'             => 'required|max_length[255]',
            'nama_pengawas'       => 'required|max_length[255]',
            'jabatan'             => 'required|max_length[255]',
            'bentuk_pengawasan'   => 'required|max_length[100]',
            'tujuan_pengawasan'   => 'required',
            'sasaran_pengawasan'  => 'required',
            'waktu_pengawasan'    => 'required',
            'tempat_pengawasan'   => 'required|max_length[255]',
            'uraian_hasil'        => 'required',
            'ada_potensi_sengketa' => 'required|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        $data['user_id'] = session()->get('user_id');
        $data['status'] = 'Draft';
        $data['nomor_lhp'] = $this->generateLhpNumber(
            (string) $data['waktu_pengawasan'],
            (string) $data['kecamatan']
        );

        if ($data['nomor_lhp'] === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor LHP gagal dibuat. Pastikan tanggal pengawasan dan kecamatan terisi dengan benar.');
        }

        // Simpan data utama terlebih dahulu.
        $this->lhpModel->insert($data);

        $lhpId = $this->lhpModel->getInsertID();

        if (!$lhpId) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data LHP gagal disimpan.');
        }

        // Simpan foto bukti pengawasan.
        $uploadResult = $this->uploadFotoBukti($lhpId);

        if ($uploadResult !== true) {
            // Hapus LHP jika proses upload gagal.
            $this->lhpModel->delete($lhpId);

            return redirect()->back()
                ->withInput()
                ->with('error', $uploadResult);
        }

        return redirect()->to('/lhp')
            ->with('success', 'LHP berhasil disimpan.');
    }

    /**
     * Menampilkan detail LHP.
     */
    public function show($id)
    {
        $lhp = $this->getLhpByAccess($id);

        if (!$lhp) {
            throw PageNotFoundException::forPageNotFound(
                'LHP tidak ditemukan atau Anda tidak memiliki akses.'
            );
        }

        $lampiran = $this->lampiranModel
            ->where('lhp_id', $id)
            ->findAll();

        return view('lhp/detail', [
            'title'    => 'Detail LHP',
            'lhp'      => $lhp,
            'lampiran' => $lampiran,
        ]);
    }

    /**
     * Menampilkan template cetak LHP sesuai hak akses pengguna.
     */
    public function cetak($id)
    {
        $lhp = $this->getLhpByAccess($id);

        if (! $lhp) {
            throw PageNotFoundException::forPageNotFound(
                'LHP tidak ditemukan atau Anda tidak memiliki akses.'
            );
        }

        $lampiran = $this->lampiranModel
            ->where('lhp_id', $id)
            ->findAll();

        return view('lhp/cetak', [
            'title'    => 'Cetak LHP',
            'lhp'      => $lhp,
            'lampiran' => $lampiran,
            'template' => (new LhpDocumentTemplateModel())->getTemplate(),
        ]);
    }

    /**
     * Menampilkan foto lampiran LHP yang dapat diakses pengguna.
     */
    public function lampiran($id)
    {
        $lampiran = $this->lampiranModel->find($id);

        if (!$lampiran || !$this->getLhpByAccess($lampiran['lhp_id'])) {
            throw PageNotFoundException::forPageNotFound(
                'Lampiran tidak ditemukan atau Anda tidak memiliki akses.'
            );
        }

        $fileName = $lampiran['nama_file'] ?? '';
        if ($fileName === '' || basename($fileName) !== $fileName) {
            throw PageNotFoundException::forPageNotFound(
                'Lampiran tidak ditemukan.'
            );
        }

        $directory = realpath(WRITEPATH . 'uploads/lhp/' . $lampiran['lhp_id']);
        if ($directory === false) {
            throw PageNotFoundException::forPageNotFound(
                'File lampiran tidak ditemukan.'
            );
        }

        $path = realpath($directory . DIRECTORY_SEPARATOR . $fileName);
        if (
            $path === false
            || !is_file($path)
            || !str_starts_with($path, $directory . DIRECTORY_SEPARATOR)
        ) {
            throw PageNotFoundException::forPageNotFound(
                'File lampiran tidak ditemukan.'
            );
        }

        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->file($path);
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            throw PageNotFoundException::forPageNotFound(
                'Format file lampiran tidak didukung.'
            );
        }

        $content = file_get_contents($path);
        if ($content === false) {
            throw new RuntimeException('File lampiran gagal dibaca.');
        }

        return $this->response
            ->setContentType($mimeType)
            ->setHeader('Content-Disposition', 'inline')
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setHeader('Cache-Control', 'private, max-age=3600')
            ->setBody($content);
    }

    /**
     * Menampilkan form edit.
     */
    public function edit($id)
    {
        if (session()->get('role') !== 'pengawas') {
            return redirect()->to('/lhp')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $lhp = $this->getOwnedLhp($id);

        if (!$lhp) {
            throw PageNotFoundException::forPageNotFound(
                'LHP tidak ditemukan.'
            );
        }

        $lampiran = $this->lampiranModel
            ->where('lhp_id', $id)
            ->findAll();

        return view('lhp/form', [
            'title'    => 'Edit LHP',
            'lhp'      => $lhp,
            'lampiran' => $lampiran,
        ]);
    }

    /**
     * Memperbarui data LHP.
     */
    public function update($id)
    {
        if (session()->get('role') !== 'pengawas') {
            return redirect()->to('/lhp')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $lhp = $this->getOwnedLhp($id);

        if (!$lhp) {
            throw PageNotFoundException::forPageNotFound(
                'LHP tidak ditemukan.'
            );
        }

        $rules = [
            'tahapan'             => 'required|max_length[255]',
            'nama_pengawas'       => 'required|max_length[255]',
            'jabatan'             => 'required|max_length[255]',
            'bentuk_pengawasan'   => 'required|max_length[100]',
            'tujuan_pengawasan'   => 'required',
            'sasaran_pengawasan'  => 'required',
            'waktu_pengawasan'    => 'required',
            'tempat_pengawasan'   => 'required|max_length[255]',
            'uraian_hasil'        => 'required',
            'ada_potensi_sengketa' => 'required|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        // Status tidak diubah ketika edit.
        $this->lhpModel->update($id, $data);

        $uploadResult = $this->uploadFotoBukti($id);

        if ($uploadResult !== true) {
            return redirect()->back()
                ->withInput()
                ->with('error', $uploadResult);
        }

        return redirect()->to('/lhp')
            ->with('success', 'LHP berhasil diperbarui.');
    }

    /**
     * Menghapus LHP milik Pengawas.
     */
    public function delete($id)
    {
        if (session()->get('role') !== 'pengawas') {
            return redirect()->to('/lhp')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $lhp = $this->getOwnedLhp($id);

        if (!$lhp) {
            return redirect()->to('/lhp')
                ->with('error', 'LHP tidak ditemukan.');
        }

        $lampiran = $this->lampiranModel
            ->where('lhp_id', $id)
            ->findAll();

        // Hapus file foto dari folder.
        foreach ($lampiran as $file) {
            $path = WRITEPATH . $file['path_file'];

            if (is_file($path)) {
                unlink($path);
            }
        }

        // Hapus data lampiran.
        $this->lampiranModel
            ->where('lhp_id', $id)
            ->delete();

        // Hapus data LHP.
        $this->lhpModel->delete($id);

        return redirect()->to('/lhp')
            ->with('success', 'LHP berhasil dihapus.');
    }

    /**
     * Mengambil data LHP milik Pengawas.
     */
    private function getOwnedLhp($id)
    {
        return $this->lhpModel
            ->where('id', $id)
            ->where('user_id', session()->get('user_id'))
            ->first();
    }

    /**
     * Mengambil LHP sesuai hak akses.
     */
    private function getLhpByAccess($id)
    {
        $role = session()->get('role');

        $builder = $this->lhpModel->where('id', $id);

        if ($role === 'pengawas') {
            $builder->where('user_id', session()->get('user_id'));
        }

        return $builder->first();
    }

    /**
     * Mengambil data Form A.
     */
    
    private function getFormData(): array
    {
        return [
            // Identitas laporan
            'tahapan' => $this->request->getPost('tahapan'),

            'nama_pengawas' => $this->request->getPost('nama_pengawas'),

            'jabatan_pengawas' => $this->request->getPost('jabatan'),

            'nomor_surat_tugas' => $this->request->getPost('nomor_spt'),

            'tanggal_surat_tugas' => $this->request->getPost('tanggal_surat_tugas'),

            'alamat_pengawas' => $this->request->getPost('alamat_pengawas'),

            // Kegiatan pengawasan
            'bentuk_pengawasan' => $this->request->getPost('bentuk_pengawasan'),

            'tujuan_pengawasan' => $this->request->getPost('tujuan_pengawasan'),

            'sasaran_pengawasan' => $this->request->getPost('sasaran_pengawasan'),

            'waktu_pengawasan' => $this->request->getPost('waktu_pengawasan'),

            'tempat_pengawasan' => $this->request->getPost('tempat_pengawasan'),

            // Wilayah pengawasan
            'kecamatan' => $this->request->getPost('kecamatan'),

            'desa' => $this->request->getPost('desa'),

            'tps' => $this->request->getPost('tps'),

            // Hasil pengawasan
            'uraian_hasil' => $this->request->getPost('uraian_hasil'),

            // Dugaan pelanggaran
            'ada_dugaan_pelanggaran' =>
                $this->request->getPost('ada_dugaan_pelanggaran') ?? 0,

            'peristiwa_pelanggaran' =>
                $this->request->getPost('peristiwa_pelanggaran'),

            'tempat_pelanggaran' =>
                $this->request->getPost('tempat_kejadian'),

            'waktu_pelanggaran' =>
                $this->request->getPost('waktu_kejadian'),

            'pelaku_pelanggaran' =>
                $this->request->getPost('pelaku'),

            'alamat_pelaku' =>
                $this->request->getPost('alamat_pelaku'),

            'saksi' => json_encode([
                [
                    'nama' => $this->request->getPost('nama_saksi_1'),
                    'alamat' => $this->request->getPost('alamat_saksi_1'),
                ],
                [
                    'nama' => $this->request->getPost('nama_saksi_2'),
                    'alamat' => $this->request->getPost('alamat_saksi_2'),
                ],
            ], JSON_UNESCAPED_UNICODE),

            'barang_bukti' => $this->request->getPost('barang_bukti'),

            'alat_bukti' => $this->request->getPost('alat_bukti'),

            'uraian_pelanggaran' =>
                $this->request->getPost('uraian_dugaan_pelanggaran'),

            'fakta_pelanggaran' =>
                $this->request->getPost('fakta_keterangan'),

            'analisa_pelanggaran' =>
                $this->request->getPost('analisa'),

            // Potensi sengketa
            'ada_potensi_sengketa' =>
                $this->request->getPost('ada_potensi_sengketa') ?? 0,

            'bentuk_objek_sengketa' =>
                $this->request->getPost('bentuk_objek_sengketa'),

            'peserta_sengketa' =>
                $this->request->getPost('peserta_sengketa'),

            'tempat_sengketa' =>
                $this->request->getPost('tempat_sengketa'),

            'waktu_sengketa' =>
                $this->formatPostDateTime('waktu_sengketa'),

            'objek_sengketa' =>
                $this->request->getPost('objek_sengketa'),

            'tanggal_objek_dikeluarkan' =>
                $this->request->getPost('tanggal_objek_dikeluarkan'),

            'kerugian_langsung' =>
                $this->request->getPost('kerugian_langsung'),

            'uraian_sengketa' =>
                $this->request->getPost('uraian_sengketa'),
        ];
    }

    private function formatPostDateTime(string $field): ?string
    {
        $value = trim((string) $this->request->getPost($field));

        if ($value === '') {
            return null;
        }

        return str_replace('T', ' ', $value) . ':00';
    }

    private function generateLhpNumber(string $waktuPengawasan, string $kecamatan): ?string
    {
        $tanggalPengawasan = substr($waktuPengawasan, 0, 10);
        $tanggalValid = \DateTimeImmutable::createFromFormat('!Y-m-d', $tanggalPengawasan);

        if (
            $tanggalValid === false
            || $tanggalValid->format('Y-m-d') !== $tanggalPengawasan
            || trim($kecamatan) === ''
        ) {
            return null;
        }

        preg_match('/^\s*(\p{L})/u', $kecamatan, $matches);
        $inisialWilayah = strtoupper($matches[1] ?? '');

        if ($inisialWilayah === '') {
            return null;
        }

        $waktuSekarang = new \DateTimeImmutable(
            'now',
            new \DateTimeZone('Asia/Jakarta')
        );
        $tahun = (int) $waktuSekarang->format('Y');
        $terlambat = $tanggalPengawasan < $waktuSekarang->format('Y-m-d');
        $db = $this->lhpModel->db;

        $db->transBegin();
        $db->query(
            'INSERT INTO lhp_nomor_sequence (tahun, nomor_terakhir) VALUES (?, 0)
             ON DUPLICATE KEY UPDATE tahun = VALUES(tahun)',
            [$tahun]
        );

        $sequence = $db->query(
            'SELECT nomor_terakhir FROM lhp_nomor_sequence WHERE tahun = ? FOR UPDATE',
            [$tahun]
        )->getRowArray();

        if ($sequence === null) {
            $db->transRollback();
            return null;
        }

        $nomorUrutTerakhir = (int) $sequence['nomor_terakhir'];
        $nomorLhpSebelumnya = $db->table('lhp')
            ->select('nomor_lhp')
            ->like('nomor_lhp', '/LHP/')
            ->get()
            ->getResultArray();

        foreach ($nomorLhpSebelumnya as $nomorSebelumnya) {
            if (
                preg_match(
                    '/^(\d+)(?:\.\p{L})?\/LHP\/(?:\d{1,2}\/)?(\d{4})(?:-[A-Z])?$/u',
                    (string) $nomorSebelumnya['nomor_lhp'],
                    $bagianNomor
                ) === 1
                && (int) $bagianNomor[2] === $tahun
            ) {
                $nomorUrutTerakhir = max($nomorUrutTerakhir, (int) $bagianNomor[1]);
            }
        }

        $nomorUrut = $nomorUrutTerakhir + 1;
        $bulan = $waktuSekarang->format('m');
        $inisialNomor = $terlambat ? '.' . $inisialWilayah : '';
        $nomorLhp = sprintf(
            '%03d%s/LHP/%s/%d',
            $nomorUrut,
            $inisialNomor,
            $bulan,
            $tahun
        );

        while ($this->lhpModel->where('nomor_lhp', $nomorLhp)->countAllResults() > 0) {
            $nomorUrut++;
            $nomorLhp = sprintf(
                '%03d%s/LHP/%s/%d',
                $nomorUrut,
                $inisialNomor,
                $bulan,
                $tahun
            );
        }

        $updated = $db->table('lhp_nomor_sequence')
            ->where('tahun', $tahun)
            ->update(['nomor_terakhir' => $nomorUrut]);

        if (! $updated || ! $db->transStatus()) {
            $db->transRollback();
            return null;
        }

        $db->transCommit();

        return $nomorLhp;
    }

    /**
     * Upload beberapa foto bukti pengawasan.
     */
    private function uploadFotoBukti(int $lhpId)
    {
        $files = $this->request->getFileMultiple('foto_bukti');

        if (empty($files)) {
            return true;
        }

        $filesToUpload = [];
        foreach ($files as $file) {
            if ($file->getError() === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            if (! $file->isValid()) {
                return 'Terdapat foto yang gagal diunggah.';
            }

            $mimeType = $file->getMimeType();
            if (! in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'], true)) {
                return 'Format foto harus JPG, PNG, atau WEBP.';
            }

            $fileSize = $file->getSize();
            if ($fileSize > 2 * 1024 * 1024) {
                return 'Ukuran setiap foto maksimal 2 MB.';
            }

            $filesToUpload[] = [
                'file'      => $file,
                'mime_type' => $mimeType,
                'size'      => $fileSize,
            ];
        }

        if ($filesToUpload === []) {
            return true;
        }

        $folder = WRITEPATH . 'uploads/lhp/' . $lhpId;
        if (! is_dir($folder) && ! mkdir($folder, 0755, true) && ! is_dir($folder)) {
            return 'Folder penyimpanan foto gagal dibuat.';
        }

        foreach ($filesToUpload as $upload) {
            $file = $upload['file'];
            $namaAsli = $file->getClientName();
            $namaFile = $file->getRandomName();
            $file->move($folder, $namaFile);

            $inserted = $this->lampiranModel->insert([
                'lhp_id'      => $lhpId,
                'nama_file'   => $namaFile,
                'nama_asli'   => $namaAsli,
                'path_file'   => 'uploads/lhp/' . $lhpId . '/' . $namaFile,
                'tipe_file'   => $upload['mime_type'],
                'ukuran_file' => $upload['size'],
                'keterangan'  => 'Foto bukti pengawasan',
            ]);

            if ($inserted === false) {
                $path = $folder . DIRECTORY_SEPARATOR . $namaFile;
                if (is_file($path)) {
                    unlink($path);
                }

                return 'Data lampiran gagal disimpan. Silakan coba kembali.';
            }
        }

        return true;
    }
}
