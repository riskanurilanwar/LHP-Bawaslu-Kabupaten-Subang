
<header class="bg-white border-b border-slate-200
               px-4 md:px-6 py-4">

    <div class="flex items-center justify-between">

        <!-- Judul Halaman -->
        <div>

            <h2 class="text-lg font-semibold text-slate-800">

                <?= esc($title ?? 'Dashboard') ?>

            </h2>

            <p class="text-xs text-slate-500 mt-1">

                Sistem Informasi Laporan Hasil Pengawasan

            </p>

        </div>

        <!-- Informasi Pengguna -->
        <div class="flex items-center gap-3">

            <div class="hidden sm:block text-right">

                <p class="text-sm font-semibold text-slate-800">

                    <?= esc(session()->get('nama')) ?>

                </p>

                <p class="text-xs text-slate-500 capitalize">

                    <?= esc(session()->get('role')) ?>

                </p>

            </div>

            <!-- Foto Profil -->
            <div class="w-10 h-10 rounded-full
                        bg-blue-100 text-blue-700
                        flex items-center justify-center
                        font-bold">

                <?= strtoupper(
                    substr(session()->get('nama') ?? 'U', 0, 1)
                ) ?>

            </div>

            <!-- Tombol Logout -->
            <button
                type="button"
                onclick="confirmLogout()"
                class="bg-red-50 hover:bg-red-100
                       text-red-600 px-4 py-2
                       rounded-lg text-sm font-medium
                       transition"
            >

                Logout

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

            title: 'Apakah Anda yakin?',
            text: 'Anda akan keluar dari sistem LHP.',
            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',

            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',

        }).then((result) => {

            if (result.isConfirmed) {

                document
                    .getElementById('logoutForm')
                    .submit();

            }

        });

    }

</script>
