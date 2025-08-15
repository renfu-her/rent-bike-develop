<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('status', 1)->paginate(12);
        return view('stores.index', compact('stores'));
    }

    public function show($id)
    {
        $store = Store::with('motorcycles')->findOrFail($id);
        return view('stores.show', compact('store'));
    }
}
