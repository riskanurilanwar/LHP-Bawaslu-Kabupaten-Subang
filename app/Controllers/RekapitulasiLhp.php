<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LhpModel;

class RekapitulasiLhp extends BaseController
{
    protected $lhpModel;

    public function __construct()
    {
        $this->lhpModel = new LhpModel();
    }

    public function index()
    {
        $role = strtolower(session()->get('role'));
        $userId = session()->get('user_id');

        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->lhpModel;

        // Staff hanya dapat melihat rekapitulasi LHP miliknya.
        if ($role === 'staff') {
            $builder = $builder->where('user_id', $userId);
        } elseif (! in_array($role, ['admin', 'pimpinan'])) {
            return redirect()->to('/dashboard')
                ->with('error', 'Anda tidak memiliki hak akses.');
        }

        // Filter bulan.
        if (! empty($bulan)) {
            $builder = $builder->where(
                'MONTH(waktu_pengawasan)',
                (int) $bulan
            );
        }

        // Filter tahun.
        if (! empty($tahun)) {
            $builder = $builder->where(
                'YEAR(waktu_pengawasan)',
                (int) $tahun
            );
        }

        $data['lhp'] = $builder
            ->orderBy('waktu_pengawasan', 'DESC')
            ->findAll();

        $data['totalLhp'] = count($data['lhp']);

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        return view('rekapitulasi/index', $data);
    }

    public function cetak()
    {
        $role = strtolower(session()->get('role'));
        $userId = session()->get('user_id');

        if (! in_array($role, ['admin', 'pimpinan', 'staff'])) {
            return redirect()->to('/dashboard')
                ->with('error', 'Anda tidak memiliki hak akses.');
        }

        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $builder = $this->lhpModel;

        // Staff hanya dapat mencetak LHP miliknya sendiri.
        if ($role === 'staff') {
            $builder = $builder->where('user_id', $userId);
        }

        if (! empty($bulan)) {
            $builder = $builder->where(
                'MONTH(waktu_pengawasan)',
                (int) $bulan
            );
        }

        if (! empty($tahun)) {
            $builder = $builder->where(
                'YEAR(waktu_pengawasan)',
                (int) $tahun
            );
        }

        $data['lhp'] = $builder
            ->orderBy('waktu_pengawasan', 'DESC')
            ->findAll();

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['tanggalCetak'] = date('d-m-Y');

        return view('rekapitulasi/cetak', $data);
    }
}