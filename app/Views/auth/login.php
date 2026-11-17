
<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem LHP Bawaslu Kabupaten Subang</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-full bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-slate-100 flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden">

    <!-- Ambient glowing lights background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-8">

        <!-- Login Container Card -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-100/80 p-6 sm:p-9 text-slate-800">

            <!-- Logo & Brand Header -->
            <div class="text-center mb-8">

                <!-- Emblem Badge -->
                <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-tr from-red-700 via-red-600 to-red-800
                            flex items-center justify-center text-white text-2xl font-black
                            shadow-xl shadow-red-950/30 ring-4 ring-red-100 mb-4 transition-transform hover:scale-105">
                    LHP
                </div>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200/60 text-red-700 text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                    PORTAL RESMI BAWASLU
                </div>

                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Sistem Informasi LHP
                </h1>

                <p class="mt-1 text-sm text-slate-500 font-medium">
                    Bawaslu Kabupaten Subang
                </p>

            </div>

            <!-- Form Login -->
            <form
                action="<?= base_url('login') ?>"
                method="POST"
                class="space-y-5"
            >

                <?= csrf_field() ?>

                <!-- Input Username -->
                <div>
                    <label
                        for="username"
                        class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2"
                    >
                        Username
                    </label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user text-sm"></i>
                        </div>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?= esc(old('username')) ?>"
                            placeholder="Masukkan username Anda"
                            required
                            autofocus
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl
                                   text-sm text-slate-900 placeholder-slate-400 font-medium
                                   focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-600
                                   transition-all duration-150 outline-none"
                        >
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label
                        for="password"
                        class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2"
                    >
                        Password
                    </label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password Anda"
                            required
                            class="w-full pl-10 pr-11 py-3 bg-slate-50 border border-slate-300 rounded-xl
                                   text-sm text-slate-900 placeholder-slate-400 font-medium
                                   focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-600
                                   transition-all duration-150 outline-none"
                        >
                        <button
                            type="button"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                            aria-label="Lihat Password"
                        >
                            <i id="passwordToggleIcon" class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button
                    type="submit"
                    class="w-full mt-2 bg-gradient-to-r from-red-700 via-red-600 to-red-800
                           hover:from-red-800 hover:via-red-700 hover:to-red-900
                           text-white font-bold py-3.5 rounded-xl text-sm
                           shadow-lg shadow-red-900/25 active:scale-[0.99]
                           transition-all duration-150 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Sistem</span>
                </button>

            </form>

            <!-- Card Footer / Keamanan -->
            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <div class="inline-flex items-center gap-2 text-xs font-medium text-slate-400">
                    <i class="fa-solid fa-shield-halved text-emerald-600 text-sm"></i>
                    <span>Akses Terenkripsi & Terverifikasi</span>
                </div>
            </div>

        </div>

        <!-- External Footer -->
        <div class="mt-6 text-center text-xs text-slate-400">
            <p class="font-medium text-slate-300">
                Sistem Informasi Laporan Hasil Pengawasan
            </p>
            <p class="mt-1 text-slate-400">
                Bawaslu Kabupaten Subang &copy; <?= date('Y') ?>
            </p>
        </div>

    </div>

    <!-- Toggle Password Visibility Client-side Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            if (!passwordInput || !toggleIcon) return;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

    <!-- SweetAlert2 Notifications -->
    <script>
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: <?= json_encode(session()->getFlashdata('error')) ?>,
                confirmButtonColor: '#b91c1c',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border border-slate-100',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md'
                }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: <?= json_encode(session()->getFlashdata('success')) ?>,
                confirmButtonColor: '#b91c1c',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border border-slate-100',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md'
                }
            });
        <?php endif; ?>
    </script>

</body>

</html>
