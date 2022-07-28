<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
 
class FirebaseController extends Controller
{
    public function index()
    {
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/livechatfirebase-e32db-firebase-adminsdk-m2m1i-0de41bb211.json')
            ->withDatabaseUri('https://livechatfirebase-e32db-default-rtdb.asia-southeast1.firebasedatabase.app');
 
        $database = $firebase->createDatabase();
 
        $blog = $database
        ->getReference('blog');
 
        echo '<pre>';
        print_r($blog->getvalue());
        echo '</pre>';
    }
}