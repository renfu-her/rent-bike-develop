<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\Store;
use App\Models\Member;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
