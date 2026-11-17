<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header Halaman -->
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="w-2 h-2 rounded-full bg-red-600"></span>
            <p class="text-xs font-bold uppercase tracking-wider text-red-700">Manajemen Personil</p>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
            <i class="fa-solid fa-clipboard-list text-red-700"></i>
            Kelola Penugasan Pengawasan
        </h1>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            Berikan mandat wilayah dan tahapan pengawasan kepada satu atau beberapa personil pengawas.
        </p>
    </div>

    <?php if (!empty(session()->getFlashdata('success'))): ?>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm font-semibold text-emerald-800 flex items-center gap-2.5">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    <?php endif; ?>

    <?php if (!empty($editingAssignment)): ?>
        <!-- Mode Edit Penugasan -->
        <section class="rounded-2xl border border-amber-300 bg-white p-6 shadow-xs sm:p-7">
            <div class="mb-5 flex items-center justify-between gap-4 pb-3 border-b border-amber-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-sm font-bold">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Edit Penugasan</h2>
                        <p class="text-xs text-slate-500">Perbarui rincian wilayah atau tahapan penugasan personil.</p>
                    </div>
                </div>
                <a href="<?= base_url('kelola-penugasan') ?>"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 px-3 py-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-xmark text-xs"></i>
                    <span>Batal</span>
                </a>
            </div>

            <?php if (!empty(session()->getFlashdata('errors'))): ?>
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-medium text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('error'))): ?>
                <p class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-medium text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </p>
            <?php endif; ?>

            <form action="<?= base_url('kelola-penugasan/update/' . $editingAssignment['id']) ?>"
                  method="post"
                  class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="edit-pengawas" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Pengguna
                    </label>
                    <select id="edit-pengawas" name="pengawas_id" required
                            <?= $editingAssignmentHasLhp ? 'disabled' : '' ?>
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 transition-all disabled:bg-slate-100 disabled:text-slate-500">
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
                        <p class="mt-1 text-xs text-amber-600 font-medium">
                            * Pengguna tidak dapat diubah karena penugasan ini sudah memiliki data LHP terkait.
                        </p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="edit-wilayah" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Wilayah / Kecamatan
                        </label>
                        <input id="edit-wilayah" name="wilayah" type="text" required maxlength="100"
                               value="<?= esc(old('wilayah', $editingAssignment['wilayah'])) ?>"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 transition-all">
                    </div>

                    <div>
                        <label for="edit-tahapan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tahapan Pengawasan
                        </label>
                        <?php $selectedTahapan = old('tahapan', $editingAssignment['tahapan']); ?>
                        <select id="edit-tahapan" name="tahapan" required
                                class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 transition-all">
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

                <p class="text-xs text-slate-400">
                    Perubahan wilayah atau tahapan tidak mengubah data formulir LHP yang sudah tersimpan sebelumnya.
                </p>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-amber-600 hover:bg-amber-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-amber-950/20 transition-all">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </form>
        </section>
    <?php endif; ?>

    <!-- Form Tambah Penugasan -->
    <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sm:p-7">
        <div class="mb-5 flex items-center gap-2.5 pb-3 border-b border-slate-100">
            <div class="w-9 h-9 rounded-xl bg-red-50 text-red-700 flex items-center justify-center text-sm font-bold">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800">Tambah Penugasan Baru</h2>
                <p class="text-xs text-slate-500">Tugaskan satu atau banyak personil ke wilayah dan tahapan tertentu.</p>
            </div>
        </div>

        <?php if (empty($editingAssignment) && !empty(session()->getFlashdata('errors'))): ?>
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-medium text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (empty($editingAssignment) && !empty(session()->getFlashdata('error'))): ?>
            <p class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-medium text-red-700">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>

        <?php if (empty($pengguna)): ?>
            <p class="rounded-xl bg-amber-50 border border-amber-200 p-4 text-xs font-medium text-amber-800">
                Belum ada akun pengguna aktif untuk diberikan penugasan.
            </p>
        <?php else: ?>
            <form action="<?= base_url('kelola-penugasan/simpan') ?>"
                  method="post"
                  class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label for="pengguna-search" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Pilih Personil Pengguna
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </div>
                        <input id="pengguna-search"
                               type="text"
                               autocomplete="off"
                               placeholder="Ketik nama atau role pengguna untuk memilih..."
                               aria-autocomplete="list"
                               aria-controls="pengguna-options"
                               aria-expanded="false"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50/70 pl-10 pr-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                        <div id="pengguna-options"
                             role="listbox"
                             class="absolute z-10 mt-1 hidden max-h-56 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white py-1 shadow-xl">
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
                                <span class="inline-flex items-center gap-2 rounded-xl bg-red-50 border border-red-200/80 px-3 py-1.5 text-xs font-bold text-red-800"
                                      data-selected-user="<?= esc($selectedId) ?>">
                                    <input type="hidden" name="pengguna_ids[]" value="<?= esc($selectedId) ?>">
                                    <span><?= esc($usersById[$selectedId]['nama']) ?> <span class="capitalize text-[10px] text-red-600">(<?= esc($usersById[$selectedId]['role']) ?>)</span></span>
                                    <button type="button" aria-label="Hapus <?= esc($usersById[$selectedId]['nama']) ?>"
                                            class="font-bold text-red-500 hover:text-red-800 ml-1"
                                            data-remove-user="<?= esc($selectedId) ?>">×</button>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <p class="mt-1.5 text-[11px] text-slate-400">
                        Ketik untuk mencari, lalu klik pengguna dari daftar untuk menambahkan. Anda dapat menugaskan beberapa orang sekaligus.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="wilayah" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Wilayah / Kecamatan
                        </label>
                        <input id="wilayah" name="wilayah" type="text" required maxlength="100"
                               value="<?= esc(old('wilayah', '')) ?>"
                               placeholder="Contoh: Kecamatan Subang"
                               class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
                    </div>

                    <div>
                        <label for="tahapan" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Tahapan Pengawasan
                        </label>
                        <select id="tahapan" name="tahapan" required
                                class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all">
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

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-red-950/20 hover:from-red-700 hover:to-red-800 transition-all">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Simpan Penugasan</span>
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </section>

    <!-- Tabel Daftar Penugasan -->
    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs">
        <div class="border-b border-slate-100 p-5 sm:p-6 flex items-center justify-between">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-table-list text-slate-400"></i>
                    Daftar Penugasan Aktif
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Penugasan yang terdaftar otomatis tersedia sebagai pilihan ketika pengguna mengisi formulir LHP.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50/90 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-left">Nama Personil</th>
                        <th class="px-5 py-3.5 text-left">Role</th>
                        <th class="px-5 py-3.5 text-left">Wilayah / Kecamatan</th>
                        <th class="px-5 py-3.5 text-left">Tahapan Pengawasan</th>
                        <th class="px-5 py-3.5 text-left">Tanggal Dibuat</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($penugasan)): ?>
                        <?php foreach ($penugasan as $item): ?>
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    <?= esc($item['nama_pengguna']) ?>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-600 capitalize">
                                        <?= esc($item['role_pengguna']) ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs font-semibold text-slate-700">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                                        <span><?= esc($item['wilayah']) ?></span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs text-slate-600">
                                    <?= esc($item['tahapan']) ?>
                                </td>
                                <td class="px-5 py-4 text-xs text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <?= !empty($item['created_at'])
                                            ? esc(date('d-m-Y', strtotime($item['created_at'])))
                                            : '-' ?>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="<?= base_url('kelola-penugasan?edit=' . $item['id']) ?>"
                                       class="inline-flex items-center gap-1 rounded-lg border border-amber-300 bg-amber-50 px-2.5 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-100 transition-colors">
                                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                                        <span>Edit</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                        <i class="fa-regular fa-clipboard"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Belum Ada Penugasan</p>
                                    <p class="text-xs text-slate-400 mt-1">Gunakan formulir di atas untuk membuat penugasan wilayah dan tahapan bagi pengawas.</p>
                                </div>
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
                empty.className = 'px-4 py-3 text-xs text-slate-500';
                empty.textContent = query === ''
                    ? 'Semua pengguna yang cocok sudah dipilih.'
                    : 'Pengguna tidak ditemukan.';
                options.appendChild(empty);
            } else {
                matches.forEach((user) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.setAttribute('role', 'option');
                    button.className = 'flex w-full items-center justify-between gap-3 px-4 py-2.5 text-left hover:bg-red-50 focus:bg-red-50 focus:outline-none transition-colors';

                    const name = document.createElement('span');
                    name.className = 'text-xs font-bold text-slate-800';
                    name.textContent = user.nama;

                    const role = document.createElement('span');
                    role.className = 'text-[11px] capitalize text-slate-500 bg-slate-100 px-2 py-0.5 rounded font-medium';
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
            chip.className = 'inline-flex items-center gap-2 rounded-xl bg-red-50 border border-red-200/80 px-3 py-1.5 text-xs font-bold text-red-800';

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
            remove.className = 'font-bold text-red-500 hover:text-red-800 ml-1 text-sm';

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
