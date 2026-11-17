<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Penugasan</h1>
        <p class="mt-1 text-sm text-slate-500">
            Berikan wilayah dan tahapan pengawasan kepada satu atau beberapa pengguna.
        </p>
    </div>

    <?php if (!empty(session()->getFlashdata('success'))): ?>
        <p class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($editingAssignment)): ?>
        <section class="rounded-xl border border-amber-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-slate-800">Edit Penugasan</h2>
                <a href="<?= base_url('kelola-penugasan') ?>"
                   class="text-sm font-medium text-slate-600 hover:text-slate-900">
                    Batal
                </a>
            </div>

            <?php if (!empty(session()->getFlashdata('errors'))): ?>
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('error'))): ?>
                <p class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </p>
            <?php endif; ?>

            <form action="<?= base_url('kelola-penugasan/update/' . $editingAssignment['id']) ?>"
                  method="post"
                  class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="edit-pengawas" class="mb-2 block text-sm font-medium text-slate-700">
                        Pengguna
                    </label>
                    <select id="edit-pengawas" name="pengawas_id" required
                            <?= $editingAssignmentHasLhp ? 'disabled' : '' ?>
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                        <option value="">Pilih Pengguna</option>
                        <?php foreach ($pengguna as $user): ?>
                            <?php
                                $selectedUserId = $editingAssignmentHasLhp
                                    ? $editingAssignment['pengawas_id']
                                    : old('pengawas_id', $editingAssignment['pengawas_id']);
                            ?>
                            <option value="<?= esc($user['id']) ?>"
                                <?= (string) $selectedUserId === (string) $user['id'] ? 'selected' : '' ?>>
                                <?= esc($user['nama']) ?> (<?= esc($user['role']) ?><?= empty($user['is_active']) ? ', nonaktif' : '' ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($editingAssignmentHasLhp): ?>
                        <input type="hidden" name="pengawas_id"
                               value="<?= esc($editingAssignment['pengawas_id']) ?>">
                        <p class="mt-1 text-xs text-slate-500">
                            Pengguna tidak dapat diubah karena penugasan ini sudah memiliki LHP.
                        </p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="edit-wilayah" class="mb-2 block text-sm font-medium text-slate-700">
                            Wilayah / Kecamatan
                        </label>
                        <input id="edit-wilayah" name="wilayah" type="text" required maxlength="100"
                               value="<?= esc(old('wilayah', $editingAssignment['wilayah'])) ?>"
                               class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>

                    <div>
                        <label for="edit-tahapan" class="mb-2 block text-sm font-medium text-slate-700">
                            Tahapan Pengawasan
                        </label>
                        <?php $selectedTahapan = old('tahapan', $editingAssignment['tahapan']); ?>
                        <select id="edit-tahapan" name="tahapan" required
                                class="w-full rounded-lg border border-slate-300 px-4 py-3">
                            <option value="">Pilih Tahapan Pengawasan</option>
                            <?php foreach ($tahapanOptions as $option): ?>
                                <option value="<?= esc($option) ?>"
                                    <?= $selectedTahapan === $option ? 'selected' : '' ?>>
                                    <?= esc($option) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <p class="text-xs text-slate-500">
                    Perubahan wilayah atau tahapan tidak mengubah data LHP yang sudah tersimpan.
                </p>
                <button type="submit"
                        class="rounded-lg bg-amber-600 px-5 py-3 text-sm font-medium text-white hover:bg-amber-700">
                    Simpan Perubahan
                </button>
            </form>
        </section>
    <?php endif; ?>

    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-5 text-lg font-semibold text-slate-800">Tambah Penugasan</h2>

        <?php if (empty($editingAssignment) && !empty(session()->getFlashdata('errors'))): ?>
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (empty($editingAssignment) && !empty(session()->getFlashdata('error'))): ?>
            <p class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>

        <?php if (empty($pengguna)): ?>
            <p class="rounded-lg bg-amber-50 p-4 text-sm text-amber-800">
                Belum ada akun pengguna aktif untuk diberikan penugasan.
            </p>
        <?php else: ?>
            <form action="<?= base_url('kelola-penugasan/simpan') ?>"
                  method="post"
                  class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="pengguna-search" class="mb-2 block text-sm font-medium text-slate-700">
                        Pilih Pengguna
                    </label>
                    <div class="relative">
                        <input id="pengguna-search"
                               type="text"
                               autocomplete="off"
                               placeholder="Ketik nama atau role pengguna..."
                               aria-autocomplete="list"
                               aria-controls="pengguna-options"
                               aria-expanded="false"
                               class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <div id="pengguna-options"
                             role="listbox"
                             class="absolute z-10 mt-1 hidden max-h-56 w-full overflow-y-auto rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
                        </div>
                    </div>
                    <div id="pengguna-terpilih" class="mt-3 flex flex-wrap gap-2">
                        <?php
                            $selectedUsers = old('pengguna_ids', []);
                            $selectedUsers = is_array($selectedUsers)
                                ? array_map('strval', $selectedUsers)
                                : [];
                            $usersById = [];
                            foreach ($pengguna as $user) {
                                $usersById[(string) $user['id']] = $user;
                            }
                        ?>
                        <?php foreach ($selectedUsers as $selectedId): ?>
                            <?php if (isset($usersById[$selectedId])): ?>
                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-sm text-blue-800"
                                      data-selected-user="<?= esc($selectedId) ?>">
                                    <input type="hidden" name="pengguna_ids[]" value="<?= esc($selectedId) ?>">
                                    <span><?= esc($usersById[$selectedId]['nama']) ?> <span class="capitalize text-xs text-blue-600">(<?= esc($usersById[$selectedId]['role']) ?>)</span></span>
                                    <button type="button" aria-label="Hapus <?= esc($usersById[$selectedId]['nama']) ?>"
                                            class="font-bold text-blue-600 hover:text-blue-900"
                                            data-remove-user="<?= esc($selectedId) ?>">×</button>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">
                        Ketik untuk mencari, lalu pilih pengguna dari dropdown. Anda dapat memilih beberapa pengguna dari semua role.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                    <label for="wilayah" class="mb-2 block text-sm font-medium text-slate-700">
                        Wilayah / Kecamatan
                    </label>
                    <input id="wilayah" name="wilayah" type="text" required maxlength="100"
                           value="<?= esc(old('wilayah', '')) ?>"
                           placeholder="Contoh: Kecamatan Subang"
                           class="w-full rounded-lg border border-slate-300 px-4 py-3">
                    </div>

                    <div>
                    <label for="tahapan" class="mb-2 block text-sm font-medium text-slate-700">
                        Tahapan Pengawasan
                    </label>
                    <select id="tahapan" name="tahapan" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3">
                        <option value="">Pilih Tahapan Pengawasan</option>
                        <?php foreach ($tahapanOptions as $option): ?>
                            <option value="<?= esc($option) ?>"
                                <?= old('tahapan') === $option ? 'selected' : '' ?>>
                                <?= esc($option) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="rounded-lg bg-blue-700 px-5 py-3 text-sm font-medium text-white hover:bg-blue-800">
                        Simpan Penugasan
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800">Daftar Penugasan</h2>
            <p class="mt-1 text-sm text-slate-500">
                Penugasan tersedia bagi pengguna yang ditugaskan saat mengisi LHP.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4 text-left">Pengguna</th>
                        <th class="p-4 text-left">Role</th>
                        <th class="p-4 text-left">Wilayah / Kecamatan</th>
                        <th class="p-4 text-left">Tahapan</th>
                        <th class="p-4 text-left">Dibuat</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penugasan)): ?>
                        <?php foreach ($penugasan as $item): ?>
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="p-4 font-medium text-slate-800">
                                    <?= esc($item['nama_pengguna']) ?>
                                </td>
                                <td class="p-4 capitalize text-slate-600"><?= esc($item['role_pengguna']) ?></td>
                                <td class="p-4 text-slate-600"><?= esc($item['wilayah']) ?></td>
                                <td class="p-4 text-slate-600"><?= esc($item['tahapan']) ?></td>
                                <td class="p-4 text-slate-600">
                                    <?= !empty($item['created_at'])
                                        ? esc(date('d-m-Y', strtotime($item['created_at'])))
                                        : '-' ?>
                                </td>
                                <td class="p-4">
                                    <a href="<?= base_url('kelola-penugasan?edit=' . $item['id']) ?>"
                                       class="inline-flex rounded-lg border border-amber-300 px-3 py-1.5 text-xs font-medium text-amber-800 hover:bg-amber-50">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Belum ada penugasan yang dibuat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    (() => {
        const users = <?= json_encode(
            array_values($pengguna),
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        ) ?>;
        const searchInput = document.getElementById('pengguna-search');
        const options = document.getElementById('pengguna-options');
        const selectedContainer = document.getElementById('pengguna-terpilih');
        if (!searchInput || !options || !selectedContainer) {
            return;
        }

        const form = searchInput.closest('form');

        const selectedIds = () => new Set(
            Array.from(
                selectedContainer.querySelectorAll('input[name="pengguna_ids[]"]'),
                (input) => input.value
            )
        );

        const closeOptions = () => {
            options.classList.add('hidden');
            searchInput.setAttribute('aria-expanded', 'false');
        };

        const renderOptions = () => {
            const query = searchInput.value.trim().toLocaleLowerCase();
            const selected = selectedIds();
            const matches = users.filter((user) => {
                const searchable = `${user.nama} ${user.role}`.toLocaleLowerCase();
                return !selected.has(String(user.id))
                    && (query === '' || searchable.includes(query));
            });

            options.replaceChildren();
            if (matches.length === 0) {
                const empty = document.createElement('p');
                empty.className = 'px-4 py-3 text-sm text-slate-500';
                empty.textContent = query === ''
                    ? 'Semua pengguna yang cocok sudah dipilih.'
                    : 'Pengguna tidak ditemukan.';
                options.appendChild(empty);
            } else {
                matches.forEach((user) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.setAttribute('role', 'option');
                    button.className = 'flex w-full items-center justify-between gap-3 px-4 py-2 text-left hover:bg-blue-50 focus:bg-blue-50 focus:outline-none';

                    const name = document.createElement('span');
                    name.className = 'text-sm font-medium text-slate-800';
                    name.textContent = user.nama;

                    const role = document.createElement('span');
                    role.className = 'text-xs capitalize text-slate-500';
                    role.textContent = user.role;

                    button.append(name, role);
                    button.addEventListener('click', () => addUser(user));
                    options.appendChild(button);
                });
            }

            options.classList.remove('hidden');
            searchInput.setAttribute('aria-expanded', 'true');
        };

        const addUser = (user) => {
            const id = String(user.id);
            if (selectedIds().has(id)) {
                return;
            }

            const chip = document.createElement('span');
            chip.dataset.selectedUser = id;
            chip.className = 'inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1.5 text-sm text-blue-800';

            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'pengguna_ids[]';
            hidden.value = id;

            const label = document.createElement('span');
            label.textContent = `${user.nama} (${user.role})`;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.textContent = '×';
            remove.setAttribute('aria-label', `Hapus ${user.nama}`);
            remove.dataset.removeUser = id;
            remove.className = 'font-bold text-blue-600 hover:text-blue-900';

            chip.append(hidden, label, remove);
            selectedContainer.appendChild(chip);
            searchInput.value = '';
            renderOptions();
            searchInput.focus();
        };

        searchInput.addEventListener('input', renderOptions);
        searchInput.addEventListener('focus', renderOptions);
        searchInput.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeOptions();
            }
        });

        selectedContainer.addEventListener('click', (event) => {
            const removeButton = event.target.closest('[data-remove-user]');
            if (!removeButton) {
                return;
            }

            selectedContainer.querySelector(
                `[data-selected-user="${CSS.escape(removeButton.dataset.removeUser)}"]`
            )?.remove();

            if (!options.classList.contains('hidden')) {
                renderOptions();
            }
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('#pengguna-search')
                && !event.target.closest('#pengguna-options')) {
                closeOptions();
            }
        });

        form.addEventListener('submit', (event) => {
            if (selectedIds().size === 0) {
                event.preventDefault();
                searchInput.focus();
                renderOptions();
            }
        });
    })();
</script>
<?= $this->endSection() ?>
