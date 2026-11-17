<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$isEdit = ! empty($user['id']);
$roleLabels = [
    'pengawas' => 'Pengawas',
    'pimpinan' => 'Pimpinan',
    'admin'    => 'Administrator',
];
$isCurrentUser = $isEdit && (int) $user['id'] === (int) session()->get('user_id');
?>

<div class="mx-auto max-w-3xl space-y-6">

    <!-- Header & Breadcrumb -->
    <div>
        <a href="<?= base_url('kelola-pengguna') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-red-700 transition-colors">
            <i class="fa-solid fa-arrow-left text-[11px]"></i>
            <span>Kembali ke Kelola Pengguna</span>
        </a>
        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
            <i class="fa-solid <?= $isEdit ? 'fa-user-pen' : 'fa-user-plus' ?> text-red-700"></i>
            <?= esc($title) ?>
        </h1>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            <?= $isEdit ? 'Perbarui informasi identitas, jabatan, dan akses akun pengguna.' : 'Buat akun baru untuk jajaran pengawas atau staf sistem LHP.' ?>
        </p>
    </div>

    <!-- Form Card -->
    <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sm:p-8">
        <form action="<?= esc($action) ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nama Lengkap <span class="text-red-600">*</span>
                    </label>
                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="<?= esc(old('nama', $user['nama'] ?? '')) ?>"
                        maxlength="150"
                        required
                        autocomplete="name"
                        placeholder="Contoh: Budi Santoso, S.H."
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                    <?php if (isset($errors['nama'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['nama']) ?></p><?php endif; ?>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Username <span class="text-red-600">*</span>
                    </label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="<?= esc(old('username', $user['username'] ?? '')) ?>"
                        minlength="3"
                        maxlength="50"
                        required
                        autocomplete="username"
                        placeholder="Contoh: budi_pengawas"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                    <?php if (isset($errors['username'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['username']) ?></p><?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?= esc(old('email', $user['email'] ?? '')) ?>"
                        maxlength="150"
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                    <?php if (isset($errors['email'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['email']) ?></p><?php endif; ?>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Role Akses <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="role"
                        name="role"
                        required
                        <?= $isCurrentUser ? 'disabled' : '' ?>
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all disabled:bg-slate-100 disabled:text-slate-400"
                    >
                        <?php foreach ($roleLabels as $value => $label) : ?>
                            <option value="<?= esc($value) ?>" <?= old('role', $user['role'] ?? 'pengawas') === $value ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($isCurrentUser) : ?>
                        <input type="hidden" name="role" value="<?= esc($user['role']) ?>">
                        <p class="mt-1 text-xs text-slate-400">Role akun sendiri tidak dapat diubah.</p>
                    <?php endif; ?>
                    <?php if (isset($errors['role'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['role']) ?></p><?php endif; ?>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Jabatan Kedinasan
                    </label>
                    <input
                        id="jabatan"
                        name="jabatan"
                        type="text"
                        value="<?= esc(old('jabatan', $user['jabatan'] ?? '')) ?>"
                        maxlength="100"
                        placeholder="Contoh: Anggota Panwaslu Kecamatan"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                    <?php if (isset($errors['jabatan'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['jabatan']) ?></p><?php endif; ?>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="no_hp" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nomor Telepon / WhatsApp
                    </label>
                    <input
                        id="no_hp"
                        name="no_hp"
                        type="tel"
                        value="<?= esc(old('no_hp', $user['no_hp'] ?? '')) ?>"
                        maxlength="20"
                        autocomplete="tel"
                        placeholder="Contoh: 08123456789"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                    <?php if (isset($errors['no_hp'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['no_hp']) ?></p><?php endif; ?>
                </div>

                <?php if ($isEdit) : ?>
                    <!-- Status Akun (Edit Only) -->
                    <div>
                        <label for="is_active" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Status Akun <span class="text-red-600">*</span>
                        </label>
                        <select
                            id="is_active"
                            name="is_active"
                            required
                            <?= $isCurrentUser ? 'disabled' : '' ?>
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="1" <?= (string) old('is_active', $user['is_active']) === '1' ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= (string) old('is_active', $user['is_active']) === '0' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <?php if ($isCurrentUser) : ?>
                            <input type="hidden" name="is_active" value="<?= esc($user['is_active']) ?>">
                            <p class="mt-1 text-xs text-slate-400">Status akun sendiri tidak dapat diubah.</p>
                        <?php endif; ?>
                        <?php if (isset($errors['is_active'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['is_active']) ?></p><?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Kata Sandi -->
                <div class="<?= $isEdit ? '' : 'sm:col-span-2' ?>">
                    <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Kata Sandi <?= $isEdit ? '' : '<span class="text-red-600">*</span>' ?>
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        <?= $isEdit ? '' : 'required' ?>
                        minlength="8"
                        maxlength="255"
                        autocomplete="new-password"
                        placeholder="<?= $isEdit ? 'Masukkan sandi baru jika ingin mengubah' : 'Minimal 8 karakter' ?>"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                    <p class="mt-1 text-xs text-slate-400">
                        <?= $isEdit ? 'Kosongkan jika kata sandi tidak ingin diubah.' : 'Gunakan kombinasi minimal 8 karakter yang aman.' ?>
                    </p>
                    <?php if (isset($errors['password'])) : ?><p class="mt-1 text-xs font-medium text-red-600"><?= esc($errors['password']) ?></p><?php endif; ?>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="<?= base_url('kelola-pengguna') ?>" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-xmark text-xs"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-red-950/20 hover:from-red-700 hover:to-red-800 transition-all">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span><?= $isEdit ? 'Simpan Perubahan' : 'Buat Pengguna' ?></span>
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>
