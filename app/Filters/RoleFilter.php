<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    ) {
        $role = session()->get('role');

        // Role yang diizinkan pada route
        $allowedRoles = $arguments ?? [];

        if (!in_array($role, $allowedRoles, true)) {
            return redirect()
                ->to('/dashboard/' . $role)
                ->with(
                    'error',
                    'Anda tidak memiliki hak akses ke halaman tersebut.'
                );
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak ada proses tambahan
    }
}
