<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfilController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = (int) session()->get('user_id');
        $profile = $this->userModel->getProfile($userId);

        if ($userId < 1 || $profile === null) {
            return redirect()->to('/login')
                ->with('error', 'Data akun tidak ditemukan. Silakan masuk kembali.');
        }

        return view('profil/index', [
            'title'   => 'Profil Saya',
            'profile' => $profile,
            'errors'  => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update()
    {
        $userId = (int) session()->get('user_id');
        $user = $this->userModel->find($userId);

        if ($userId < 1 || $user === null) {
            return redirect()->to('/login')
                ->with('error', 'Data akun tidak ditemukan. Silakan masuk kembali.');
        }

        $rules = [
            'nama' => 'required|max_length[150]',
            'email' => 'permit_empty|valid_email|max_length[150]|is_unique[users.email,id,' . $userId . ']',
            'jabatan' => 'permit_empty|max_length[100]',
            'no_hp' => 'permit_empty|max_length[20]',
        ];

        $messages = [
            'nama' => [
                'required'   => 'Nama wajib diisi.',
                'max_length' => 'Nama maksimal 150 karakter.',
            ],
            'email' => [
                'valid_email' => 'Format email tidak valid.',
                'max_length'  => 'Email maksimal 150 karakter.',
                'is_unique'   => 'Email tersebut sudah digunakan akun lain.',
            ],
            'jabatan' => [
                'max_length' => 'Jabatan maksimal 100 karakter.',
            ],
            'no_hp' => [
                'max_length' => 'Nomor telepon maksimal 20 karakter.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->to('/profil')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $updated = $this->userModel->update($userId, [
            'nama'    => trim((string) $this->request->getPost('nama')),
            'email'   => trim((string) $this->request->getPost('email')) ?: null,
            'jabatan' => trim((string) $this->request->getPost('jabatan')) ?: null,
            'no_hp'   => trim((string) $this->request->getPost('no_hp')) ?: null,
        ]);

        if (! $updated) {
            return redirect()->to('/profil')
                ->withInput()
                ->with('error', 'Profil gagal disimpan. Silakan coba kembali.');
        }

        session()->set('nama', trim((string) $this->request->getPost('nama')));

        return redirect()->to('/profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $userId = (int) session()->get('user_id');
        $user = $this->userModel->find($userId);

        if ($userId < 1 || $user === null) {
            return redirect()->to('/login')
                ->with('error', 'Data akun tidak ditemukan. Silakan masuk kembali.');
        }

        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[8]|max_length[255]',
            'konfirmasi_password' => 'required|matches[password_baru]',
        ];

        $messages = [
            'password_lama' => [
                'required' => 'Kata sandi saat ini wajib diisi.',
            ],
            'password_baru' => [
                'required'   => 'Kata sandi baru wajib diisi.',
                'min_length' => 'Kata sandi baru minimal 8 karakter.',
                'max_length' => 'Kata sandi baru maksimal 255 karakter.',
            ],
            'konfirmasi_password' => [
                'required' => 'Konfirmasi kata sandi wajib diisi.',
                'matches'  => 'Konfirmasi kata sandi tidak sama.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->to('/profil')
                ->with('errors', $this->validator->getErrors());
        }

        $passwordLama = (string) $this->request->getPost('password_lama');

        if (! password_verify($passwordLama, $user['password'])) {
            return redirect()->to('/profil')
                ->with('errors', [
                    'password_lama' => 'Kata sandi saat ini tidak sesuai.',
                ]);
        }

        $updated = $this->userModel->update($userId, [
            'password' => password_hash(
                (string) $this->request->getPost('password_baru'),
                PASSWORD_DEFAULT
            ),
        ]);

        if (! $updated) {
            return redirect()->to('/profil')
                ->with('error', 'Kata sandi gagal diperbarui. Silakan coba kembali.');
        }

        return redirect()->to('/profil')
            ->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
