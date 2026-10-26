<?php

namespace App\Controllers;

use App\Models\UserModel;

class KelolaPengguna extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('keyword'));
        $role = trim((string) $this->request->getGet('role'));
        $status = trim((string) $this->request->getGet('status'));

        $builder = $this->userModel
            ->select('id, nama, username, email, role, jabatan, no_hp, is_active, created_at')
            ->orderBy('nama', 'ASC');

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('nama', $keyword)
                ->orLike('username', $keyword)
                ->orLike('email', $keyword)
                ->groupEnd();
        }

        if (in_array($role, ['pengawas', 'pimpinan', 'admin'], true)) {
            $builder->where('role', $role);
        }

        if (in_array($status, ['0', '1'], true)) {
            $builder->where('is_active', (int) $status);
        }

        return view('kelola_pengguna/index', [
            'title'   => 'Kelola Pengguna',
            'users'   => $builder->paginate(10),
            'pager'   => $this->userModel->pager,
            'keyword' => $keyword,
            'role'    => $role,
            'status'  => $status,
        ]);
    }

    public function create()
    {
        return view('kelola_pengguna/form', [
            'title'  => 'Tambah Pengguna',
            'user'   => [],
            'errors' => session()->getFlashdata('errors') ?? [],
            'action' => base_url('kelola-pengguna/simpan'),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|max_length[150]',
            'username' => 'required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'    => 'permit_empty|valid_email|max_length[150]|is_unique[users.email]',
            'role'     => 'required|in_list[pengawas,pimpinan,admin]',
            'jabatan'  => 'permit_empty|max_length[100]',
            'no_hp'    => 'permit_empty|max_length[20]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];

        if (! $this->validate($rules, $this->validationMessages())) {
            return $this->redirectWithSafeInput('/kelola-pengguna/tambah')
                ->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->insert($this->getUserData(true));

        if (! $userId) {
            return $this->redirectWithSafeInput('/kelola-pengguna/tambah')
                ->with('error', 'Pengguna gagal ditambahkan. Silakan coba kembali.');
        }

        return redirect()->to('/kelola-pengguna')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = $this->userModel
            ->select('id, nama, username, email, role, jabatan, no_hp, is_active')
            ->find($id);

        if ($user === null) {
            return redirect()->to('/kelola-pengguna')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        return view('kelola_pengguna/form', [
            'title'  => 'Edit Pengguna',
            'user'   => $user,
            'errors' => session()->getFlashdata('errors') ?? [],
            'action' => base_url('kelola-pengguna/update/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);

        if ($user === null) {
            return redirect()->to('/kelola-pengguna')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        $usernameRule = 'required|alpha_numeric_punct|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']';
        $emailRule = 'permit_empty|valid_email|max_length[150]|is_unique[users.email,id,' . $id . ']';
        $rules = [
            'nama'     => 'required|max_length[150]',
            'username' => $usernameRule,
            'email'    => $emailRule,
            'role'     => 'required|in_list[pengawas,pimpinan,admin]',
            'jabatan'  => 'permit_empty|max_length[100]',
            'no_hp'    => 'permit_empty|max_length[20]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
            'is_active' => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules, $this->validationMessages())) {
            return $this->redirectWithSafeInput('/kelola-pengguna/edit/' . $id)
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getUserData(false);
        $data['is_active'] = (int) $this->request->getPost('is_active');

        if ((int) session()->get('user_id') === $id) {
            $data['role'] = $user['role'];
            $data['is_active'] = $user['is_active'];
        }

        if (
            $user['role'] === 'admin'
            && (int) $user['is_active'] === 1
            && ($data['role'] !== 'admin' || $data['is_active'] !== 1)
            && $this->countOtherActiveAdmins($id) === 0
        ) {
            return $this->redirectWithSafeInput('/kelola-pengguna/edit/' . $id)
                ->with('error', 'Admin aktif terakhir tidak dapat dinonaktifkan atau diubah rolenya.');
        }

        $this->addPasswordIfProvided($data);

        if (! $this->userModel->update($id, $data)) {
            return $this->redirectWithSafeInput('/kelola-pengguna/edit/' . $id)
                ->with('error', 'Data pengguna gagal diperbarui. Silakan coba kembali.');
        }

        if ((int) session()->get('user_id') === $id) {
            session()->set('nama', $data['nama']);
        }

        return redirect()->to('/kelola-pengguna')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function toggleStatus(int $id)
    {
        $user = $this->userModel->find($id);

        if ($user === null) {
            return redirect()->to('/kelola-pengguna')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        if ((int) session()->get('user_id') === $id) {
            return redirect()->to('/kelola-pengguna')
                ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $newStatus = (int) $user['is_active'] === 1 ? 0 : 1;

        if (
            $newStatus === 0
            && $user['role'] === 'admin'
            && $this->countOtherActiveAdmins($id) === 0
        ) {
            return redirect()->to('/kelola-pengguna')
                ->with('error', 'Akun admin aktif terakhir tidak dapat dinonaktifkan.');
        }

        if (! $this->userModel->update($id, ['is_active' => $newStatus])) {
            return redirect()->to('/kelola-pengguna')
                ->with('error', 'Status pengguna gagal diperbarui. Silakan coba kembali.');
        }

        $message = $newStatus === 1
            ? 'Akun pengguna berhasil diaktifkan.'
            : 'Akun pengguna berhasil dinonaktifkan.';

        return redirect()->to('/kelola-pengguna')
            ->with('success', $message);
    }

    private function getUserData(bool $includePassword): array
    {
        $data = [
            'nama'     => trim((string) $this->request->getPost('nama')),
            'username' => trim((string) $this->request->getPost('username')),
            'email'    => trim((string) $this->request->getPost('email')) ?: null,
            'role'     => (string) $this->request->getPost('role'),
            'jabatan'  => trim((string) $this->request->getPost('jabatan')) ?: null,
            'no_hp'    => trim((string) $this->request->getPost('no_hp')) ?: null,
        ];

        if ($includePassword) {
            $data['password'] = password_hash(
                (string) $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
            $data['is_active'] = 1;
        }

        return $data;
    }

    private function addPasswordIfProvided(array &$data): void
    {
        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    private function countOtherActiveAdmins(int $userId): int
    {
        return (new UserModel())
            ->where('role', 'admin')
            ->where('is_active', 1)
            ->where('id !=', $userId)
            ->countAllResults();
    }

    private function redirectWithSafeInput(string $url)
    {
        $post = $this->request->getPost();
        unset($post['password']);

        session()->setFlashdata('_ci_old_input', [
            'get'  => $this->request->getGet(),
            'post' => $post,
        ]);

        return redirect()->to($url);
    }

    private function validationMessages(): array
    {
        return [
            'nama' => [
                'required'   => 'Nama wajib diisi.',
                'max_length' => 'Nama maksimal 150 karakter.',
            ],
            'username' => [
                'required'              => 'Username wajib diisi.',
                'alpha_numeric_punct'   => 'Username hanya boleh berisi huruf, angka, dan tanda baca.',
                'min_length'            => 'Username minimal 3 karakter.',
                'max_length'            => 'Username maksimal 50 karakter.',
                'is_unique'             => 'Username sudah digunakan.',
            ],
            'email' => [
                'valid_email' => 'Format email tidak valid.',
                'max_length'  => 'Email maksimal 150 karakter.',
                'is_unique'   => 'Email sudah digunakan akun lain.',
            ],
            'role' => [
                'required' => 'Role wajib dipilih.',
                'in_list'  => 'Role yang dipilih tidak valid.',
            ],
            'jabatan' => [
                'max_length' => 'Jabatan maksimal 100 karakter.',
            ],
            'no_hp' => [
                'max_length' => 'Nomor telepon maksimal 20 karakter.',
            ],
            'password' => [
                'required'   => 'Kata sandi wajib diisi.',
                'min_length' => 'Kata sandi minimal 8 karakter.',
                'max_length' => 'Kata sandi maksimal 255 karakter.',
            ],
            'is_active' => [
                'required' => 'Status akun wajib dipilih.',
                'in_list'  => 'Status akun tidak valid.',
            ],
        ];
    }
}
