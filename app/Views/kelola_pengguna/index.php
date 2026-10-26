<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$roleLabels = [
    'admin'    => 'Administrator',
    'pimpinan' => 'Pimpinan',
    'pengawas' => 'Pengawas',
];
?>

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-blue-700">Administrasi</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-800">Kelola Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">Tambah akun, perbarui informasi, dan atur akses pengguna.</p>
        </div>
        <a
            href="<?= base_url('kelola-pengguna/tambah') ?>"
            class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800"
        >
            + Tambah Pengguna
        </a>
    </div>

    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <form action="<?= base_url('kelola-pengguna') ?>" method="get" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <input
                type="search"
                name="keyword"
                value="<?= esc($keyword) ?>"
                placeholder="Cari nama, username, email..."
                class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
            >
            <select name="role" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500">
                <option value="">Semua role</option>
                <?php foreach ($roleLabels as $value => $label) : ?>
                    <option value="<?= esc($value) ?>" <?= $role === $value ? 'selected' : '' ?>>
                        <?= esc($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="status" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500">
                <option value="">Semua status</option>
                <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Nonaktif</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-medium text-white hover:bg-slate-700">
                    Terapkan
                </button>
                <a href="<?= base_url('kelola-pengguna') ?>" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Pengguna</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Kontak</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Role / Jabatan</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-5 py-3 text-right font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if ($users !== []) : ?>
                        <?php foreach ($users as $user) : ?>
                            <tr class="hover:bg-slate-50">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="font-semibold text-slate-800"><?= esc($user['nama']) ?></p>
                                    <p class="mt-0.5 text-xs text-slate-500">@<?= esc($user['username']) ?></p>
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    <p><?= esc($user['email'] ?: '-') ?></p>
                                    <p class="mt-0.5 text-xs text-slate-400"><?= esc($user['no_hp'] ?: '-') ?></p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="font-medium text-slate-700"><?= esc($roleLabels[$user['role']] ?? $user['role']) ?></p>
                                    <p class="mt-0.5 text-xs text-slate-500"><?= esc($user['jabatan'] ?: '-') ?></p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <?php if ((int) $user['is_active'] === 1) : ?>
                                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">Aktif</span>
                                    <?php else : ?>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="<?= base_url('kelola-pengguna/edit/' . $user['id']) ?>"
                                            class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100"
                                        >
                                            Edit
                                        </a>
                                        <?php if ((int) $user['id'] !== (int) session()->get('user_id')) : ?>
                                            <form action="<?= base_url('kelola-pengguna/status/' . $user['id']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button
                                                    type="submit"
                                                    class="rounded-md px-3 py-1.5 text-xs font-semibold <?= (int) $user['is_active'] === 1 ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' ?>"
                                                >
                                                    <?= (int) $user['is_active'] === 1 ? 'Nonaktifkan' : 'Aktifkan' ?>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                                Tidak ada pengguna yang cocok dengan pencarian.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 px-5 py-4">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
