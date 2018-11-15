<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
*/

/**
 * @var $api Dingo\Api\Routing\Router
 */
$api = app("Dingo\Api\Routing\Router");

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'prefix'    => 'auth',
], function($api) {
    $api->group([
        // 频率限制
        'middleware' => 'api.throttle',
        // 总分钟下总多少次
        'limit' => config('api.rate_limits.sign.limit'),
        //总分钟数
        'expires' => config('api.rate_limits.sign.expires'),
    ], function($api) {
        // 这些需要验证 TOKEN 的
        $api->group([
            'middleware' => 'jwt.auth'
        ],function($api){
            $api->post('logout', 'AuthController@logout');
            $api->post('me', 'AuthController@me');
            $api->post('refresh', 'AuthController@refresh');

        });
        $api->post('login', 'AuthController@login');
        $api->post('register', 'AuthController@register');
    });
});
