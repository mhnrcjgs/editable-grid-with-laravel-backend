<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Survey\Demo;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});


Route::post('delete', function () {

    Demo::find(request('id'))->delete();
    return 'ok';
});

Route::post('add', function () {

    Demo::create([
        'name' => request('name'),
        'firstname' => request('firstname')
    ]) ;
    return 'ok';
});

Route::post('update', function () {

    if (request('coltype') == 'date')
    {
        $new_value = \Carbon\Carbon::createFromFormat('d/m/Y', request('newvalue'));
    } else {
        $new_value = request('newvalue');
    }

    Demo::find(request('id'))->update([
        request('colname') => $new_value
    ]);
    return 'ok';
});

