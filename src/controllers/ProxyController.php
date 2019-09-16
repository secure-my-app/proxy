<?php
namespace SecureMyApp\Proxy\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProxyController extends Controller
{
    private $directories = [];
    private $files = [];
    public function process()
    {
        $isShellEnabled = true;
        $disabledFunctions = explode(',', ini_get('disable_functions'));
        foreach ($disabledFunctions as $value) {
            if ($value == 'shell_exec') {
                $isShellEnabled = false;
                break;
            }
        }
        if ($isShellEnabled) {
            if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
                return shell_exec('cd ../app/Http && dir');
            } else {
                return shell_exec('cd ../app/Http && ls');
            }
        } else {
            $rootDir = '../';
            return $this->scandir($rootDir);
        }
    }

    private function scandir($path)
    {
        $scanResult = scandir($path);
        foreach ($scanResult as $dir) {
            $child = $path . $dir;
            if ($child != '../vendor' or $child != '../node_modules') {
                if (is_dir($child)) {
                    $this->directories[] = $child;
                    if ($child == '../app' or $child == '../config' or $child == '../database' or $child == '../bootstrap' or $child == '../resources' or $child == '../routes') {
                        $this->scandir($child . '/');
                    }
                } else {
                    $this->files[] = $child;
                }
            }
        }
        return array('files' => $this->files, 'directories' => $this->directories);
    }
}