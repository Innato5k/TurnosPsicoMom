<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artisan;
use GuzzleHttp\Client;
class ConfigController extends Controller
{
        public function clearAll(){
            $clearcache = Artisan::call('cache:clear');
            echo "Cache cleared<br>";
        
            $clearview = Artisan::call('view:clear');
            echo "View cleared<br>";
            $clearview = Artisan::call('route:clear');
            echo "Route cleared<br>";
        
            $clearconfig = Artisan::call('config:clear');
            echo "Config cleared<br>";
        }

        public function cacheAll(){
            $optimize = Artisan::call('optimize --force');
            echo "Optimized<br>";

            $clearconfig = Artisan::call('config:cache');
            echo "Config cached<br>";

            $clearconfig = Artisan::call('route:cache');
            echo "Route cached<br>";
        
        }
        public function test(){
            return view('servicios/programar');
        }
}