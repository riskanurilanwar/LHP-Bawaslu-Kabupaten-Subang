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
    <div>
        <a href="<?= base_url('kelola-pengguna') ?>" class="text-sm font-medium text-blue-700 hover:text-blue-800">
            &larr; Kembali ke Kelola Pengguna
        </a>
        <h1 class="mt-3 text-2xl font-bold text-slate-800"><?= esc($title) ?></h1>
        <p class="mt-1 text-sm text-slate-500">
            <?= $isEdit ? 'Perbarui informasi dan akses akun pengguna.' : 'Buat akun untuk pengguna sistem LHP.' ?>
        </p>
    </div>

    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form action="<?= esc($action) ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="nama" class="mb-2 block text-sm font-medium text-slate-700">Nama lengkap <span class="text-red-600">*</span></label>
                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="<?= esc(old('nama', $user['nama'] ?? '')) ?>"
                        maxlength="150"
                        required
                        autocomplete="name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['nama'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['nama']) ?></p><?php endif; ?>
                </div>

                <div>
                    <label for="username" class="mb-2 block text-sm font-medium text-slate-700">Username <span class="text-red-600">*</span></label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="<?= esc(old('username', $user['username'] ?? '')) ?>"
                        minlength="3"
                        maxlength="50"
                        required
                        autocomplete="username"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['username'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['username']) ?></p><?php endif; ?>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?= esc(old('email', $user['email'] ?? '')) ?>"
                        maxlength="150"
                        autocomplete="email"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['email'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['email']) ?></p><?php endif; ?>
                </div>

                <div>
                    <label for="role" class="mb-2 block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                    <select
                        id="role"
                        name="role"
                        required
                        <?= $isCurrentUser ? 'disabled' : '' ?>
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 disabled:bg-slate-100 disabled:text-slate-500"
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
                    <?php if (isset($errors['role'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['role']) ?></p><?php endif; ?>
                </div>

                <div>
                    <label for="jabatan" class="mb-2 block text-sm font-medium text-slate-700">Jabatan</label>
                    <input
                        id="jabatan"
                        name="jabatan"
                        type="text"
                        value="<?= esc(old('jabatan', $user['jabatan'] ?? '')) ?>"
                        maxlength="100"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['jabatan'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['jabatan']) ?></p><?php endif; ?>
                </div>

                <div>
                    <label for="no_hp" class="mb-2 block text-sm font-medium text-slate-700">Nomor telepon</label>
                    <input
                        id="no_hp"
                        name="no_hp"
                        type="tel"
                        value="<?= esc(old('no_hp', $user['no_hp'] ?? '')) ?>"
                        maxlength="20"
                        autocomplete="tel"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <?php if (isset($errors['no_hp'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['no_hp']) ?></p><?php endif; ?>
                </div>

                <?php if ($isEdit) : ?>
                    <div>
                        <label for="is_active" class="mb-2 block text-sm font-medium text-slate-700">Status akun <span class="text-red-600">*</span></label>
                        <select
                            id="is_active"
                            name="is_active"
                            required
                            <?= $isCurrentUser ? 'disabled' : '' ?>
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 disabled:bg-slate-100 disabled:text-slate-500"
                        >
                            <option value="1" <?= (string) old('is_active', $user['is_active']) === '1' ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= (string) old('is_active', $user['is_active']) === '0' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                        <?php if ($isCurrentUser) : ?>
                            <input type="hidden" name="is_active" value="<?= esc($user['is_active']) ?>">
                            <p class="mt-1 text-xs text-slate-400">Status akun sendiri tidak dapat diubah.</p>
                        <?php endif; ?>
                        <?php if (isset($errors['is_active'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['is_active']) ?></p><?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="<?= $isEdit ? '' : 'sm:col-span-2' ?>">
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                        Kata sandi <?= $isEdit ? '' : '<span class="text-red-600">*</span>' ?>
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        <?= $isEdit ? '' : 'required' ?>
                        minlength="8"
                        maxlength="255"
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                    <p class="mt-1 text-xs text-slate-400">
                        <?= $isEdit ? 'Kosongkan jika kata sandi tidak ingin diubah.' : 'Minimal 8 karakter.' ?>
                    </p>
                    <?php if (isset($errors['password'])) : ?><p class="mt-1 text-sm text-red-600"><?= esc($errors['password']) ?></p><?php endif; ?>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a href="<?= base_url('kelola-pengguna') ?>" class="rounded-lg border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                    <?= $isEdit ? 'Simpan Perubahan' : 'Buat Pengguna' ?>
                </button>
            </div>
        </form>
    </section>
</div>

<?= $this->endSection() ?>
