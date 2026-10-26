
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | Sistem LHP Bawaslu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex items-center justify-center p-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

            <!-- Logo -->
            <div class="text-center mb-8">

                <div class="mx-auto w-16 h-16 bg-blue-700
                            rounded-2xl flex items-center
                            justify-center text-white
                            text-2xl font-bold">
                    LHP
                </div>

                <h1 class="mt-4 text-2xl font-bold text-slate-800">
                    Sistem Informasi LHP
                </h1>

                <p class="mt-2 text-sm text-slate-500">
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

                <!-- Username -->
                <div>

                    <label
                        for="username"
                        class="block text-sm font-medium
                               text-slate-700 mb-2"
                    >
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= esc(old('username')) ?>"
                        placeholder="Masukkan username"
                        required
                        autofocus
                        class="w-full px-4 py-3 border
                               border-slate-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500
                               outline-none"
                    >

                </div>

                <!-- Password -->
                <div>

                    <label
                        for="password"
                        class="block text-sm font-medium
                               text-slate-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        class="w-full px-4 py-3 border
                               border-slate-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500
                               outline-none"
                    >

                </div>

                <!-- Tombol Login -->
                <button
                    type="submit"
                    class="w-full bg-blue-700
                           hover:bg-blue-800
                           text-white font-semibold
                           py-3 rounded-lg
                           transition duration-200"
                >
                    Login
                </button>

            </form>

            <div class="mt-8 text-center">

                <p class="text-xs text-slate-400">
                    Sistem Informasi Laporan Hasil Pengawasan
                </p>

                <p class="text-xs text-slate-400 mt-1">
                    Bawaslu Kabupaten Subang
                </p>

            </div>

        </div>

    </div>

    <!-- SweetAlert2 Notifications -->
    <script>

        <?php if (session()->getFlashdata('error')) : ?>

            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: <?= json_encode(
                    session()->getFlashdata('error')
                ) ?>,
                confirmButtonColor: '#1d4ed8'
            });

        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: <?= json_encode(
                    session()->getFlashdata('success')
                ) ?>,
                confirmButtonColor: '#1d4ed8'
            });

        <?php endif; ?>

    </script>

</body>

</html>
