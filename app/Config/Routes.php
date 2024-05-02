<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'CMSRoutesController::login');
$routes->post('/loginAction', 'CMSController::loginAction');

//==============CMS Routes==============
$routes->group('cms', function ($routes) {
    $routes->get('dashboard', 'CMSRoutesController::dashboard');

    $routes->group('contact', function ($routes) {
        $routes->get('/', 'CMSRoutesController::contact');
        $routes->post('create', 'CMSController::contactCreate');
        $routes->get('delete/(:any)', 'CMSController::contactDelete/$1');
    });

    $routes->group('client', function ($routes) {
        $routes->get('/', 'CMSRoutesController::client');
        $routes->post('create', 'CMSController::clientCreate');
        $routes->post('edit/(:num)', 'CMSController::clientEdit/$1');
        $routes->get('detail/(:num)', 'CMSController::clientDetail/$1');
        $routes->get('delete/(:num)', 'CMSController::clientDelete/$1');
        $routes->get('api', 'CMSRoutesController::ClientApi');
    });

    $routes->group('photo', function ($routes) {
        $routes->get('/', 'CMSRoutesController::photo');
        $routes->post('create', 'CMSController::photoCreate');
        $routes->get('edit/(:num)', 'CMSController::photoEdit/$1');
        $routes->get('detail/(:num)', 'CMSController::photoDetail/$1');
        $routes->get('detailDelete/(:num)', 'CMSController::photodetailDelete/$1');
        $routes->get('api', 'CMSRoutesController::PhotoApi');
    });

    $routes->group('portfolio', function ($routes) {
        $routes->get('/', 'CMSRoutesController::portfolio');
        $routes->post('create', 'CMSController::portfolioCreate');
        $routes->post('edit/(:num)', 'CMSController::portfolioEdit/$1');
        $routes->get('detail/(:num)', 'CMSController::portfolioDetail/$1');
        $routes->get('delete/(:num)', 'CMSController::portfolioDelete/$1');
        $routes->get('api', 'CMSRoutesController::PortfolioApi');
    });

    $routes->group('service', function ($routes) {
        $routes->get('/', 'CMSRoutesController::service');
        $routes->post('create', 'CMSController::serviceCreate');
        $routes->get('detail/(:num)', 'CMSController::serviceDetail/$1');
        $routes->post('edit/(:num)', 'CMSController::serviceEdit/$1');
        $routes->get('delete/(:num)', 'CMSController::serviceDelete/$1');
        $routes->get('api', 'CMSRoutesController::ServiceApi');
    });
});

//==============Absensi Routes==============
$routes->group('absensi', function ($routes) {
    $routes->get('/', 'AbsensiRoutesController::login');
    $routes->get('login', 'AbsensiRoutesController::login');
    $routes->get('loginAction', 'AbsensiController::loginAction');


    // Admin Routes
    $routes->get('dashboard', 'AbsensiRoutesController::dashboard');
    $routes->get('dashboardFilter/(:any)', 'AbsensiController::dashboardFilter/$1');
    // ================


    // Operator Routes
    $routes->get('operator/dashboard', 'AbsensiRoutesController::operatorDashboard');
    $routes->post('addAkunAction', 'AbsensiController::addAkunAction');
    // ================

    // Mahasiswa Routes
    $routes->get('form_kehadiran', 'AbsensiRoutesController::form_kehadiran');
    $routes->post('loginAction', 'AbsensiController::loginAction');
    $routes->post('kehadiranAction', 'AbsensiController::kehadiranAction');
    $routes->get('keluarAction', 'AbsensiController::keluarAction');
    // ================

});
$routes->get('logout', 'AbsensiController::logout');
