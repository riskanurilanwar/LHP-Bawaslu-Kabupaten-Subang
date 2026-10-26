<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Menampilkan halaman Login.
     */
    public function login()
    {
        // Jika sudah login, arahkan ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(
                $this->getDashboardUrl(
                    session()->get('role')
                )
            );
        }

        return view('auth/login');
    }

    /**
     * Memproses Login pengguna.
     */
    public function attemptLogin()
    {
        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                ],
            ],

            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = trim(
            $this->request->getPost('username')
        );

        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel->getByUsername($username);

        // Periksa akun dan password
        if (
            !$user ||
            !password_verify($password, $user['password'])
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Username atau password salah.');
        }

        // Periksa status akun
        if ((int) $user['is_active'] !== 1) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Akun Anda tidak aktif. Hubungi Admin.'
                );
        }

        // Regenerasi session untuk keamanan
        session()->regenerate();

        // Simpan data pengguna ke session
        session()->set([
            'user_id'    => $user['id'],
            'nama'       => $user['nama'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'jabatan'    => $user['jabatan'],
            'foto_profil' => $user['foto_profil'],
            'isLoggedIn' => true,
        ]);

        // Arahkan berdasarkan role
        return redirect()->to(
            $this->getDashboardUrl($user['role'])
        )->with(
            'success',
            'Login berhasil. Selamat datang, ' . $user['nama'] . '!'
        );
    }

    /**
     * Proses Logout.
     */
    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with(
                'success',
                'Anda berhasil logout.'
            );
    }

    /**
     * Menentukan URL dashboard berdasarkan role.
     */
    private function getDashboardUrl(string $role): string
    {
        $dashboards = [
            'pengawas' => '/dashboard/pengawas',
            'pimpinan' => '/dashboard/pimpinan',
            'admin'    => '/dashboard/admin',
        ];

        return $dashboards[$role] ?? '/login';
    }
}
