
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= esc($title ?? 'Sistem LHP Bawaslu') ?>
    </title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Konfigurasi Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bawaslu: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#172554'
                        }
                    }
                }
            }
        }
    </script>

    <?= $this->renderSection('styles') ?>

</head>

<body class="bg-slate-100 text-slate-800">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>

        <!-- Main Content -->
        <div class="flex-1 min-w-0 flex flex-col">

            <!-- Navbar -->
            <?= $this->include('partials/navbar') ?>

            <!-- Content -->
            <main class="flex-1 p-4 md:p-6">

                <?= $this->renderSection('content') ?>

            </main>

            <!-- Footer -->
            <footer class="px-6 py-4 text-center
                           text-xs text-slate-400">

                Sistem Informasi Laporan Hasil Pengawasan
                <br>

                Bawaslu Kabupaten Subang

            </footer>

        </div>

    </div>

    <!-- SweetAlert2 Notifications -->
    <script>

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

        <?php if (session()->getFlashdata('error')) : ?>

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: <?= json_encode(
                    session()->getFlashdata('error')
                ) ?>,
                confirmButtonColor: '#1d4ed8'
            });

        <?php endif; ?>

    </script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>
