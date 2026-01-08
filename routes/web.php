    <?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

// 1. Route Halaman Utama
$router->get('/', function () use ($router) {
    return $router->app->version();
}); // <--- Tutup fungsi ini di sini!

// 2. Route Group dipindahkan ke LUAR fungsi di atas
$router->group(['prefix' => 'api/Category'], function () use ($router) {
    $router->get('/', 'CategoryController@index');
    $router->post('/', 'CategoryController@store');
    $router->get('/{id}', 'CategoryController@show');
    $router->put('/{id}', 'CategoryController@update');
    $router->delete('/{id}', 'CategoryController@destroy');
});

$router->group(['prefix' => 'api/Product'], function () use ($router) {
    $router->get('/', 'ProductController@index');
    $router->post('/', 'ProductController@store');
    $router->get('/{id}', 'ProductController@show');
    $router->put('/{id}', 'ProductController@update');
    $router->delete('/{id}', 'ProductController@destroy');
});
