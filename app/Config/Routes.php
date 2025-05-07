<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('/api/save?name=(:any)', 'Home::save/$1');

$routes->group('api', function ($routes) {
    // Mahasiswa API
    $routes->get('mahasiswa', 'Api\MahasiswaApiController::index');
    $routes->get('mahasiswa/(:segment)', 'Api\MahasiswaApiController::show/$1');
    $routes->post('mahasiswa', 'Api\MahasiswaApiController::create');
    $routes->put('mahasiswa/(:segment)', 'Api\MahasiswaApiController::update/$1');
    $routes->delete('mahasiswa/(:segment)', 'Api\MahasiswaApiController::delete/$1');

    // Detail Nilai API
    $routes->get('nilai', 'Api\DetailNilaiApiController::index');
    $routes->get('nilai/(:segment)', 'Api\DetailNilaiApiController::show/$1');
    $routes->post('nilai', 'Api\DetailNilaiApiController::create');
    $routes->put('nilai/(:segment)', 'Api\DetailNilaiApiController::update/$1');
    $routes->delete('nilai/(:segment)', 'Api\DetailNilaiApiController::delete/$1');

    // NilaiNilai API
    $routes->get('nilainilai', 'Api\NilaiNilaiApiController::index');
    $routes->get('nilainilai/(:segment)', 'Api\NilaiNilaiApiController::show/$1');
    $routes->get('nilainilai/id/(:num)', 'Api\NilaiNilaiApiController::showById/$1');
    $routes->get('nilainilai/vw_nilai/(:segment)', 'Api\NilaiNilaiApiController::gets/$1');
    $routes->post('nilainilai', 'Api\NilaiNilaiApiController::create');
    $routes->put('nilainilai/(:segment)', 'Api\NilaiNilaiApiController::update/$1');
    $routes->delete('nilainilai/(:segment)', 'Api\NilaiNilaiApiController::delete/$1');
    


    // Dosen API
    $routes->get('dosen', 'Api\DosenApiController::index');
    $routes->get('dosen/(:segment)', 'Api\DosenApiController::show/$1');
    $routes->post('dosen', 'Api\DosenApiController::create');
    $routes->put('dosen/(:segment)', 'Api\DosenApiController::update/$1');
    $routes->delete('dosen/(:segment)', 'Api\DosenApiController::delete/$1');
    $routes->post('dosen/login', 'Api\DosenApiController::login');

    // Matkul
    $routes->get('matkul', 'Api\MatkulApiController::index');
    $routes->get('matkul', 'Api\MatkulApiController::index');
    $routes->post('matkul', 'Api\MatkulApiController::create');
    $routes->get('matkul/dosen/(:segment)', 'Api\MatkulApiController::getByIdDosen/$1');
    
    $routes->put('matkul/(:segment)', 'Api\MatkulApiController::update/$1');
    $routes->delete('matkul/(:segment)', 'Api\MatkulApiController::delete/$1');
});