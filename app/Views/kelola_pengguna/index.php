<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$roleLabels = [
    'admin'    => 'Administrator',
    'pimpinan' => 'Pimpinan',
    'pengawas' => 'Pengawas',
];

$roleBadges = [
    'admin'    => 'bg-red-50 text-red-700 ring-1 ring-red-600/20',
    'pimpinan' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20',
    'pengawas' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20',
];
?>

<div class="space-y-6">

    <!-- Header Halaman -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                <p class="text-xs font-bold uppercase tracking-wider text-red-700">Administrasi Sistem</p>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
                <i class="fa-solid fa-users text-red-700"></i>
                Kelola Pengguna
            </h1>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Tambah akun baru, perbarui data profil, dan atur hak akses pengguna sistem LHP Bawaslu.
            </p>
        </div>

        <a
            href="<?= base_url('kelola-pengguna/tambah') ?>"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-900/30 hover:from-red-700 hover:to-red-800 transition-all duration-150 shrink-0"
        >
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Tambah Pengguna</span>
        </a>
    </div>

    <!-- Filter dan Pencarian -->
    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs">
        <form action="<?= base_url('kelola-pengguna') ?>" method="get" class="grid gap-3.5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input
                    type="search"
                    name="keyword"
                    value="<?= esc($keyword) ?>"
                    placeholder="Cari nama, username, email..."
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/70 pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                >
            </div>

            <select name="role" class="rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 outline-none focus:bg-white focus:border-red-500 transition-all">
                <option value="">Semua role</option>
                <?php foreach ($roleLabels as $value => $label) : ?>
                    <option value="<?= esc($value) ?>" <?= $role === $value ? 'selected' : '' ?>>
                        <?= esc($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="status" class="rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 outline-none focus:bg-white focus:border-red-500 transition-all">
                <option value="">Semua status</option>
                <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Nonaktif</option>
            </select>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-slate-900 transition-colors">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan</span>
                </button>
                <a href="<?= base_url('kelola-pengguna') ?>" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </section>

    <!-- Tabel Pengguna -->
    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50/90 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-left">Nama & Username</th>
                        <th class="px-5 py-3.5 text-left">Kontak</th>
                        <th class="px-5 py-3.5 text-left">Role & Jabatan</th>
                        <th class="px-5 py-3.5 text-left">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if ($users !== []) : ?>
                        <?php foreach ($users as $user) : ?>
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-800 to-slate-950 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                            <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900"><?= esc($user['nama']) ?></p>
                                            <p class="text-xs text-slate-400">@<?= esc($user['username']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs text-slate-600">
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <i class="fa-regular fa-envelope text-slate-400 text-[11px]"></i>
                                        <span><?= esc($user['email'] ?: '-') ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-400 mt-1">
                                        <i class="fa-solid fa-phone text-[10px]"></i>
                                        <span><?= esc($user['no_hp'] ?: '-') ?></span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $roleBadges[$user['role']] ?? 'bg-slate-100 text-slate-700' ?>">
                                        <?= esc($roleLabels[$user['role']] ?? $user['role']) ?>
                                    </span>
                                    <p class="mt-1 text-xs text-slate-500 font-medium"><?= esc($user['jabatan'] ?: '-') ?></p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <?php $isActive = (int) $user['is_active'] === 1; ?>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold
                                        <?= $isActive ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20' : 'bg-slate-100 text-slate-600' ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $isActive ? 'bg-emerald-500' : 'bg-slate-400' ?>"></span>
                                        <?= $isActive ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a
                                            href="<?= base_url('kelola-pengguna/edit/' . $user['id']) ?>"
                                            class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition-colors"
                                        >
                                            <i class="fa-regular fa-pen-to-square text-xs"></i>
                                            <span>Edit</span>
                                        </a>
                                        <?php if ((int) $user['id'] !== (int) session()->get('user_id')) : ?>
                                            <form action="<?= base_url('kelola-pengguna/status/' . $user['id']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold transition-colors
                                                        <?= (int) $user['is_active'] === 1
                                                            ? 'bg-red-50 text-red-700 hover:bg-red-100 border border-red-200/50'
                                                            : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/50' ?>"
                                                >
                                                    <i class="fa-solid <?= (int) $user['is_active'] === 1 ? 'fa-ban' : 'fa-check' ?> text-[10px]"></i>
                                                    <span><?= (int) $user['is_active'] === 1 ? 'Nonaktifkan' : 'Aktifkan' ?></span>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                        <i class="fa-solid fa-user-xmark"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Pengguna Tidak Ditemukan</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ada data pengguna yang cocok dengan kriteria pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-3.5">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
