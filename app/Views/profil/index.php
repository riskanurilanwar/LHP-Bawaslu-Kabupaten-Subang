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

    <!-- Header Halaman -->
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="w-2 h-2 rounded-full bg-red-600"></span>
            <p class="text-xs font-bold uppercase tracking-wider text-red-700">Akun Pengguna</p>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
            <i class="fa-solid fa-user-circle text-red-700"></i>
            Profil Saya
        </h1>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            Kelola informasi data diri, jabatan, serta keamanan kata sandi akun Anda.
        </p>
    </div>

    <!-- Hero Card Profile -->
    <section class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xs">
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 px-6 py-8 text-white sm:px-8">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-5">
                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr from-red-600 to-amber-600 text-3xl font-black text-white shadow-xl shadow-red-950/40 ring-4 ring-white/20">
                    <?= esc($inisial) ?>
                </div>

                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-2xl font-extrabold tracking-tight text-white"><?= esc($profile['nama']) ?></h2>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-0.5 text-xs font-semibold text-slate-200 border border-white/20 backdrop-blur-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <?= esc($labelRole) ?>
                        </span>
                    </div>
                    <p class="mt-1 text-slate-300 text-sm font-medium">
                        <?= esc($profile['jabatan'] ?: 'Badan Pengawas Pemilihan Umum Kab. Subang') ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Info Strip -->
        <div class="grid gap-4 px-6 py-5 sm:grid-cols-3 sm:px-8 bg-slate-50/50 border-t border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-500 shadow-2xs shrink-0">
                    <i class="fa-solid fa-at text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Username</p>
                    <p class="font-bold text-slate-800 text-sm">@<?= esc($profile['username']) ?></p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-500 shadow-2xs shrink-0">
                    <i class="fa-regular fa-envelope text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Alamat Email</p>
                    <p class="font-bold text-slate-800 text-sm truncate"><?= esc($profile['email'] ?: 'Belum diatur') ?></p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-500 shadow-2xs shrink-0">
                    <i class="fa-solid fa-phone text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Telepon</p>
                    <p class="font-bold text-slate-800 text-sm"><?= esc($profile['no_hp'] ?: 'Belum diatur') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid Forms: Data Diri & Keamanan -->
    <div class="grid gap-6 lg:grid-cols-2">

        <!-- Form Ubah Profil -->
        <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sm:p-7">
            <div class="mb-5 flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-red-50 text-red-700 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Informasi Data Diri</h2>
                    <p class="text-xs text-slate-500">Perbarui rincian kontak dan profil Anda.</p>
                </div>
            </div>

            <form action="<?= base_url('profil/update') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="nama" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="<?= esc($nama) ?>"
                        maxlength="150"
                        required
                        autocomplete="name"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                    <?php if (isset($errors['nama'])) : ?>
                        <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['nama']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="username" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Username</label>
                    <input
                        type="text"
                        id="username"
                        value="<?= esc($profile['username']) ?>"
                        disabled
                        class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm text-slate-500"
                    >
                    <p class="mt-1 text-[11px] text-slate-400">Username akun tidak dapat diubah.</p>
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= esc(old('email', $profile['email'] ?? '')) ?>"
                        maxlength="150"
                        autocomplete="email"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                    <?php if (isset($errors['email'])) : ?>
                        <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="jabatan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Jabatan</label>
                        <input
                            type="text"
                            id="jabatan"
                            name="jabatan"
                            value="<?= esc(old('jabatan', $profile['jabatan'] ?? '')) ?>"
                            maxlength="100"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                        >
                        <?php if (isset($errors['jabatan'])) : ?>
                            <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['jabatan']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="no_hp" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Nomor Telepon</label>
                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="<?= esc(old('no_hp', $profile['no_hp'] ?? '')) ?>"
                            maxlength="20"
                            autocomplete="tel"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                        >
                        <?php if (isset($errors['no_hp'])) : ?>
                            <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['no_hp']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex justify-end pt-3">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-red-950/20 hover:from-red-700 hover:to-red-800 transition-all"
                    >
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- Form Ubah Kata Sandi -->
        <section class="h-fit rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sm:p-7">
            <div class="mb-5 flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Keamanan Kata Sandi</h2>
                    <p class="text-xs text-slate-500">Perbarui kata sandi untuk melindungi akun Anda.</p>
                </div>
            </div>

            <form action="<?= base_url('profil/update-password') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="password_lama" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Kata Sandi Saat Ini</label>
                    <input
                        type="password"
                        id="password_lama"
                        name="password_lama"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                    <?php if (isset($errors['password_lama'])) : ?>
                        <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['password_lama']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="password_baru" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Kata Sandi Baru</label>
                    <input
                        type="password"
                        id="password_baru"
                        name="password_baru"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                    <?php if (isset($errors['password_baru'])) : ?>
                        <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['password_baru']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="konfirmasi_password" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Konfirmasi Kata Sandi Baru</label>
                    <input
                        type="password"
                        id="konfirmasi_password"
                        name="konfirmasi_password"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi baru"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                    <?php if (isset($errors['konfirmasi_password'])) : ?>
                        <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors['konfirmasi_password']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 shadow-xs hover:bg-slate-50 transition-colors"
                    >
                        <i class="fa-solid fa-key text-xs"></i>
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </div>
            </form>
        </section>

    </div>

</div>

<?= $this->endSection() ?>
