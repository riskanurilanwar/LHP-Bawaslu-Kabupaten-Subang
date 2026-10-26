<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$nama = old('nama', $profile['nama'] ?? '');
$inisial = strtoupper(substr(trim($profile['nama'] ?? 'P'), 0, 1));
$labelRole = [
    'admin'    => 'Administrator',
    'pimpinan' => 'Pimpinan',
    'pengawas' => 'Pengawas / Staff',
][$profile['role'] ?? ''] ?? 'Pengguna';
?>

<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <p class="text-sm font-medium text-blue-700">Akun Anda</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-800">Profil Saya</h1>
        <p class="mt-1 text-sm text-slate-500">
            Kelola informasi akun dan keamanan akses Anda.
        </p>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-gradient-to-r from-blue-800 to-blue-600 px-6 py-7 text-white sm:px-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl border border-white/30 bg-white/15 text-3xl font-bold">
                    <?= esc($inisial) ?>
                </div>
                <div>
                    <h2 class="text-2xl font-bold"><?= esc($profile['nama']) ?></h2>
                    <p class="mt-1 text-blue-100"><?= esc($profile['jabatan'] ?: $labelRole) ?></p>
                    <span class="mt-3 inline-flex rounded-full border border-white/30 bg-white/10 px-3 py-1 text-xs font-semibold">
                        <?= esc($labelRole) ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid gap-4 px-6 py-5 sm:grid-cols-3 sm:px-8">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Username</p>
                <p class="mt-1 font-semibold text-slate-700"><?= esc($profile['username']) ?></p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Email</p>
                <p class="mt-1 font-semibold text-slate-700"><?= esc($profile['email'] ?: 'Belum diatur') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Nomor telepon</p>
                <p class="mt-1 font-semibold text-slate-700"><?= esc($profile['no_hp'] ?: 'Belum diatur') ?></p>
            </div>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-800">Informasi Profil</h2>
                <p class="mt-1 text-sm text-slate-500">Perbarui informasi yang digunakan pada akun Anda.</p>
            </div>

            <form action="<?= base_url('profil/update') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label for="nama" class="mb-2 block text-sm font-medium text-slate-700">Nama lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="<?= esc($nama) ?>"
                        maxlength="150"
                        required
                        autocomplete="name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['nama'])) : ?>
                        <p class="mt-1 text-sm text-red-600"><?= esc($errors['nama']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="username" class="mb-2 block text-sm font-medium text-slate-700">Username</label>
                    <input
                        type="text"
                        id="username"
                        value="<?= esc($profile['username']) ?>"
                        disabled
                        class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-500"
                    >
                    <p class="mt-1 text-xs text-slate-400">Username tidak dapat diubah dari halaman profil.</p>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= esc(old('email', $profile['email'] ?? '')) ?>"
                        maxlength="150"
                        autocomplete="email"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['email'])) : ?>
                        <p class="mt-1 text-sm text-red-600"><?= esc($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="jabatan" class="mb-2 block text-sm font-medium text-slate-700">Jabatan</label>
                        <input
                            type="text"
                            id="jabatan"
                            name="jabatan"
                            value="<?= esc(old('jabatan', $profile['jabatan'] ?? '')) ?>"
                            maxlength="100"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        <?php if (isset($errors['jabatan'])) : ?>
                            <p class="mt-1 text-sm text-red-600"><?= esc($errors['jabatan']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="no_hp" class="mb-2 block text-sm font-medium text-slate-700">Nomor telepon</label>
                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="<?= esc(old('no_hp', $profile['no_hp'] ?? '')) ?>"
                            maxlength="20"
                            autocomplete="tel"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        <?php if (isset($errors['no_hp'])) : ?>
                            <p class="mt-1 text-sm text-red-600"><?= esc($errors['no_hp']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex justify-end border-t border-slate-100 pt-5">
                    <button
                        type="submit"
                        class="rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>

        <section class="h-fit rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl text-amber-700">
                    &#128274;
                </div>
                <h2 class="text-lg font-bold text-slate-800">Keamanan Akun</h2>
                <p class="mt-1 text-sm text-slate-500">Gunakan kata sandi yang kuat dan tidak digunakan di tempat lain.</p>
            </div>

            <form action="<?= base_url('profil/update-password') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label for="password_lama" class="mb-2 block text-sm font-medium text-slate-700">Kata sandi saat ini</label>
                    <input
                        type="password"
                        id="password_lama"
                        name="password_lama"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['password_lama'])) : ?>
                        <p class="mt-1 text-sm text-red-600"><?= esc($errors['password_lama']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="password_baru" class="mb-2 block text-sm font-medium text-slate-700">Kata sandi baru</label>
                    <input
                        type="password"
                        id="password_baru"
                        name="password_baru"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <p class="mt-1 text-xs text-slate-400">Minimal 8 karakter.</p>
                    <?php if (isset($errors['password_baru'])) : ?>
                        <p class="mt-1 text-sm text-red-600"><?= esc($errors['password_baru']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="konfirmasi_password" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi kata sandi baru</label>
                    <input
                        type="password"
                        id="konfirmasi_password"
                        name="konfirmasi_password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['konfirmasi_password'])) : ?>
                        <p class="mt-1 text-sm text-red-600"><?= esc($errors['konfirmasi_password']) ?></p>
                    <?php endif; ?>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >
                    Perbarui Kata Sandi
                </button>
            </form>
        </section>
    </div>
</div>

<?= $this->endSection() ?>
