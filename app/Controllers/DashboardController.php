<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LhpModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    /**
     * Dashboard Pengawas.
     */
    public function pengawas()
    {
        $lhpModel = new LhpModel();

        $userId = (int) session()->get('user_id');

        $data = [
            'title' => 'Dashboard Pengawas',

            'totalLhp' => $lhpModel->countByUser($userId),

            'totalDraft' => $lhpModel
                ->where('user_id', $userId)
                ->where('status', 'draft')
                ->countAllResults(),

            'totalDikirim' => $lhpModel
                ->where('user_id', $userId)
                ->where('status', 'dikirim')
                ->countAllResults(),

            'lhpTerbaru' => $lhpModel
                ->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->findAll(5),
        ];

        return view('dashboards/pengawas', $data);
    }

    /**
     * Dashboard Pimpinan.
     */
    public function pimpinan()
    {
        $lhpModel = new LhpModel();

        $data = [
            'title' => 'Dashboard Pimpinan',

            'totalLhp' => $lhpModel->countAllLhp(),

            'totalDraft' => $lhpModel
                ->where('status', 'draft')
                ->countAllResults(),

            'totalDikirim' => $lhpModel
                ->where('status', 'dikirim')
                ->countAllResults(),

            'lhpTerbaru' => $lhpModel
                ->orderBy('created_at', 'DESC')
                ->findAll(5),
        ];

        return view('dashboards/pimpinan', $data);
    }

    /**
     * Dashboard Admin.
     */
    public function admin()
    {
        $userModel = new UserModel();

        $lhpModel = new LhpModel();

        $data = [
            'title' => 'Dashboard Admin',

            'totalPengguna' => $userModel->countAllResults(),

            'totalPengawas' => $userModel
                ->where('role', 'pengawas')
                ->countAllResults(),

            'totalPimpinan' => $userModel
                ->where('role', 'pimpinan')
                ->countAllResults(),

            'totalAdmin' => $userModel
                ->where('role', 'admin')
                ->countAllResults(),

            'totalLhp' => $lhpModel->countAllLhp(),
        ];

        return view('dashboards/admin', $data);
    }
}
