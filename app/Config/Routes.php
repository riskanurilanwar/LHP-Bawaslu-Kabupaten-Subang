<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================================================
// ROUTE DEFAULT
// =====================================================

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);


// =====================================================
// ROUTE LOGIN
// =====================================================

// Halaman utama diarahkan ke Login
$routes->get('/', 'AuthController::login');

// Menampilkan halaman Login
$routes->get('/login', 'AuthController::login');

// Memproses Login
$routes->post('/login', 'AuthController::attemptLogin');


// =====================================================
// ROUTE LOGOUT
// =====================================================

$routes->post(
    '/logout',
    'AuthController::logout',
    ['filter' => 'auth']
);



 // =====================================================
 // ROUTE DASHBOARD
 // =====================================================

// Dashboard Pengawas
$routes->get(
    'dashboard/pengawas',
    'DashboardController::pengawas',
    [
        'filter' => ['auth', 'role:pengawas']
    ]
);

// Dashboard Pimpinan
$routes->get(
    'dashboard/pimpinan',
    'DashboardController::pimpinan',
    [
        'filter' => ['auth', 'role:pimpinan']
    ]
);

// Dashboard Admin
$routes->get(
    'dashboard/admin',
    'DashboardController::admin',
    [
        'filter' => ['auth', 'role:admin']
    ]
);



// =====================================================
// ROUTE PROFILE
// =====================================================

// Halaman profil pengguna
$routes->get(
    '/profil',
    'ProfilController::index',
    ['filter' => 'auth']
);

// Memperbarui profil pengguna
$routes->post(
    '/profil/update',
    'ProfilController::update',
    ['filter' => 'auth']
);

// Memperbarui password
$routes->post(
    '/profil/update-password',
    'ProfilController::updatePassword',
    ['filter' => 'auth']
);

// =====================================================
// ROUTE KELOLA PENGGUNA
// =====================================================

$routes->get(
    'kelola-pengguna',
    'KelolaPengguna::index',
    ['filter' => ['auth', 'role:admin']]
);

$routes->get(
    'kelola-pengguna/tambah',
    'KelolaPengguna::create',
    ['filter' => ['auth', 'role:admin']]
);

$routes->post(
    'kelola-pengguna/simpan',
    'KelolaPengguna::store',
    ['filter' => ['auth', 'role:admin']]
);

$routes->get(
    'kelola-pengguna/edit/(:num)',
    'KelolaPengguna::edit/$1',
    ['filter' => ['auth', 'role:admin']]
);

$routes->post(
    'kelola-pengguna/update/(:num)',
    'KelolaPengguna::update/$1',
    ['filter' => ['auth', 'role:admin']]
);

$routes->post(
    'kelola-pengguna/status/(:num)',
    'KelolaPengguna::toggleStatus/$1',
    ['filter' => ['auth', 'role:admin']]
);

$routes->get(
    'kelola-template-lhp',
    'KelolaTemplateLhp::index',
    ['filter' => ['auth', 'role:admin']]
);

$routes->post(
    'kelola-template-lhp/update',
    'KelolaTemplateLhp::update',
    ['filter' => ['auth', 'role:admin']]
);


 // =====================================================
 // ROUTE KELOLA LHP
 // =====================================================

// Daftar LHP
$routes->get(
    'lhp',
    'Lhp::index',
    ['filter' => 'auth']
);

// Form tambah LHP
$routes->get(
    'lhp/tambah',
    'Lhp::create',
    ['filter' => ['auth', 'role:pengawas,admin,pimpinan']]
);

// Simpan LHP
$routes->post(
    'lhp/simpan',
    'Lhp::store',
    ['filter' => ['auth', 'role:pengawas,admin,pimpinan']]
);

// Detail LHP
$routes->get(
    'lhp/detail/(:num)',
    'Lhp::show/$1',
    ['filter' => 'auth']
);

// Template cetak LHP
$routes->get(
    'lhp/cetak/(:num)',
    'Lhp::cetak/$1',
    ['filter' => 'auth']
);

// Foto lampiran LHP
$routes->get(
    'lhp/lampiran/(:num)',
    'Lhp::lampiran/$1',
    ['filter' => 'auth']
);

// Form edit LHP
$routes->get(
    'lhp/edit/(:num)',
    'Lhp::edit/$1',
    ['filter' => ['auth', 'role:pengawas']]
);

// Update LHP
$routes->post(
    'lhp/update/(:num)',
    'Lhp::update/$1',
    ['filter' => ['auth', 'role:pengawas']]
);

// Hapus LHP
$routes->post(
    'lhp/hapus/(:num)',
    'Lhp::delete/$1',
    ['filter' => ['auth', 'role:pengawas']]
);

$routes->get('monitoring-lhp', 'MonitoringLhp::index', [
    'filter' => 'auth'
]);

$routes->post(
    'monitoring-lhp/status/(:num)',
    'MonitoringLhp::updateStatus/$1'
);

$routes->get(
    'rekapitulasi-lhp',
    'RekapitulasiLhp::index'
);

$routes->get(
    'rekapitulasi-lhp/cetak',
    'RekapitulasiLhp::cetak'
);