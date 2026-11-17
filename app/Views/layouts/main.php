
<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem LHP Bawaslu') ?> - Bawaslu Kabupaten Subang</title>

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

    <!-- Konfigurasi Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                    colors: {
                        bawaslu: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#172554',
                            red: '#b91c1c',
                            'red-dark': '#991b1b',
                            'red-light': '#dc2626',
                            gold: '#d97706',
                            navy: '#0f172a'
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'glow-red': '0 4px 20px -2px rgba(220, 38, 38, 0.25)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom subtle scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions */
        .transition-default {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-full flex flex-col">

    <div class="min-h-screen flex relative">

        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>

        <!-- Main Content Wrapper -->
        <div class="flex-1 min-w-0 flex flex-col bg-slate-50/70">

            <!-- Navbar -->
            <?= $this->include('partials/navbar') ?>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Footer -->
            <footer class="mt-auto border-t border-slate-200/80 bg-white/60 py-4 px-6 text-center text-xs text-slate-500 backdrop-blur-xs">
                <div class="flex flex-col sm:flex-row items-center justify-between max-w-7xl mx-auto gap-2">
                    <p class="font-medium text-slate-600">
                        <span class="text-red-700 font-semibold">Sistem Informasi LHP</span> &copy; <?= date('Y') ?> Bawaslu Kabupaten Subang
                    </p>
                    <p class="text-slate-400">
                        Bersama Rakyat Awasi Pemilu, Bersama Bawaslu Tegakkan Keadilan Pemilu
                    </p>
                </div>
            </footer>

        </div>

    </div>

    <!-- SweetAlert2 Notifications -->
    <script>
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: <?= json_encode(session()->getFlashdata('success')) ?>,
                confirmButtonColor: '#b91c1c',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md'
                }
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Pemberitahuan',
                text: <?= json_encode(session()->getFlashdata('error')) ?>,
                confirmButtonColor: '#b91c1c',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-100',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md'
                }
            });
        <?php endif; ?>
    </script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>
