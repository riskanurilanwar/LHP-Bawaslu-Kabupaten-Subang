<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LhpModel;
use App\Models\UserModel;
use DateTimeImmutable;

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
        $db = db_connect();

        $currentMonth = new DateTimeImmutable('first day of this month');
        $startMonth = $currentMonth->modify('-11 months');
        $endMonth = $currentMonth->modify('+1 month');
        $monthLabels = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];
        $monthlyTotals = [];
        $monthlyLhp = [];

        for ($month = $startMonth; $month < $endMonth; $month = $month->modify('+1 month')) {
            $key = $month->format('Y-m');
            $monthlyTotals[$key] = 0;
            $monthlyLhp[] = [
                'label' => $monthLabels[(int) $month->format('n')] . ' ' . $month->format('Y'),
                'total' => 0,
            ];
        }

        $monthlyRows = $db->table('lhp')
            ->select("DATE_FORMAT(created_at, '%Y-%m') AS bulan, COUNT(*) AS total", false)
            ->where('created_at >=', $startMonth->format('Y-m-d 00:00:00'))
            ->where('created_at <', $endMonth->format('Y-m-d 00:00:00'))
            ->groupBy('bulan')
            ->get()
            ->getResultArray();

        foreach ($monthlyRows as $row) {
            if (array_key_exists($row['bulan'], $monthlyTotals)) {
                $monthlyTotals[$row['bulan']] = (int) $row['total'];
            }
        }

        foreach ($monthlyLhp as $index => $month) {
            $key = $startMonth->modify('+' . $index . ' months')->format('Y-m');
            $monthlyLhp[$index]['total'] = $monthlyTotals[$key];
        }

        $monthlyMaximum = max(1, ...array_values($monthlyTotals));
        foreach ($monthlyLhp as $index => $month) {
            $monthlyLhp[$index]['height'] = $month['total'] > 0
                ? (int) round(($month['total'] / $monthlyMaximum) * 100)
                : 0;
        }

        $wilayahRows = $db->table('lhp')
            ->select("COALESCE(NULLIF(kecamatan, ''), 'Tidak disebutkan') AS wilayah, COUNT(*) AS total", false)
            ->groupBy('wilayah')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $tahapanRows = $db->table('lhp')
            ->select('tahapan, COUNT(*) AS total')
            ->groupBy('tahapan')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $latestLhp = $db->table('lhp')
            ->select('lhp.id, lhp.nomor_lhp, lhp.nama_pengawas, lhp.tahapan, lhp.kecamatan, lhp.desa, lhp.created_at, lhp.status, users.nama AS nama_pengisi, users.role AS role_pengisi')
            ->join('users', 'users.id = lhp.user_id', 'left')
            ->orderBy('lhp.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard Pimpinan',

            'totalLhp' => $lhpModel->countAllLhp(),

            'totalDraft' => $lhpModel
                ->where('status', 'draft')
                ->countAllResults(),

            'totalDikirim' => $lhpModel
                ->where('status', 'dikirim')
                ->countAllResults(),
            'lhpTerbaru' => $latestLhp,
            'ringkasanWilayah' => $wilayahRows,
            'ringkasanTahapan' => $tahapanRows,
            'lhpBulanan' => $monthlyLhp,
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
        $userId = (int) session()->get('user_id');

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
            'totalLhpSaya' => $lhpModel
                ->where('user_id', $userId)
                ->countAllResults(),
            'lhpTerbaruSaya' => $lhpModel
                ->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->findAll(5),
        ];

        return view('dashboards/admin', $data);
    }
}
