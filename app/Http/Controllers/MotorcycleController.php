<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\Store;
use Illuminate\Http\Request;

class MotorcycleController extends Controller
{
    public function index(Request $request)
    {
        $query = Motorcycle::with('store');

        // Search by name or model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter by store
        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $motorcycles = $query->paginate(12);

        // Get stores for the dropdown
        $stores = Store::where('status', '啟用')->get();
        
        // Debug: Add stores count to the view
        $storesCount = $stores->count();

        return view('motorcycles.index', compact('motorcycles', 'stores', 'storesCount'));
    }

    public function rent($id)
    {
        $motorcycle = Motorcycle::with('store')->findOrFail($id);
        
                       if ($motorcycle->status !== 'available') {
            return redirect()->route('motorcycles.index')
                ->with('error', '此機車目前無法預約');
        }

        return view('motorcycles.rent', compact('motorcycle'));
    }
}
