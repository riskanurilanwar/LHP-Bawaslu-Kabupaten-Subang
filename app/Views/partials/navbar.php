
<header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 py-3.5 shadow-xs">

    <div class="flex items-center justify-between gap-4 max-w-7xl mx-auto">

        <!-- Sisi Kiri: Tombol Menu Mobile & Judul Halaman -->
        <div class="flex items-center gap-3.5 min-w-0">

            <!-- Tombol Hamburger Mobile -->
            <button
                type="button"
                onclick="toggleSidebar()"
                class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-colors"
                aria-label="Buka Menu"
            >
                <i class="fa-solid fa-bars text-lg"></i>
            </button>

            <!-- Judul Halaman & Subtitle -->
            <div class="min-w-0">

                <div class="flex items-center gap-2">
                    <h2 class="text-base sm:text-lg font-bold text-slate-800 truncate">
                        <?= esc($title ?? 'Dashboard') ?>
                    </h2>
                </div>

                <p class="text-xs text-slate-500 hidden sm:block truncate">
                    Sistem Informasi Laporan Hasil Pengawasan
                </p>

            </div>

        </div>

        <!-- Sisi Kanan: Profil & Tombol Logout -->
        <div class="flex items-center gap-3 sm:gap-4 shrink-0">

            <!-- Card Profil Singkat -->
            <div class="flex items-center gap-3 pl-2 sm:pl-3 py-1">

                <div class="hidden sm:block text-right">

                    <p class="text-sm font-semibold text-slate-800 leading-tight truncate max-w-[160px]">
                        <?= esc(session()->get('nama')) ?>
                    </p>

                    <div class="flex items-center justify-end gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <p class="text-[11px] font-medium text-slate-500 capitalize">
                            <?= esc(session()->get('role')) ?>
                        </p>
                    </div>

                </div>

                <!-- Avatar Inisial -->
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-amber-600 text-white
                            flex items-center justify-center font-bold text-sm shadow-md shadow-red-950/20 ring-2 ring-white">
                    <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
                </div>

            </div>

            <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

            <!-- Tombol Logout -->
            <button
                type="button"
                onclick="confirmLogout()"
                class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 active:bg-red-200
                       text-red-700 hover:text-red-800 px-3.5 py-2
                       rounded-xl text-xs sm:text-sm font-semibold
                       border border-red-200/60 shadow-xs transition-all duration-150"
                title="Keluar dari sistem"
            >
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="hidden sm:inline">Keluar</span>
            </button>

        </div>

    </div>

</header>

<!-- Form Logout -->
<form
    id="logoutForm"
    action="<?= base_url('logout') ?>"
    method="POST"
    class="hidden"
>
    <?= csrf_field() ?>
</form>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: 'Apakah Anda yakin ingin keluar dari sistem LHP Bawaslu?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b91c1c',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa-solid fa-arrow-right-from-bracket mr-1.5"></i> Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-slate-100',
                confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md',
                cancelButton: 'px-5 py-2.5 rounded-xl font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    }
</script>
