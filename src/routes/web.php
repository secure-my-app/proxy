<?php

Route::group(['prefix' => config('secure-my-app.prefix', 'S3Cur3My4pPfR0mTh13f'), 'middleware' => 'web'], function() {
	Route::get('process', 'SecureMyApp\Proxy\Controllers\ProxyController@process');
});