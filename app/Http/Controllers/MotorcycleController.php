<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\Store;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class MotorcycleController extends Controller
{
    public function index(Request $request)
    {
        $query = Motorcycle::with('store');

        // Search by name or model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
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

        return view('motorcycles.index', compact('motorcycles', 'stores'));
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

    public function storeRent(Request $request, $id)
    {
        $motorcycle = Motorcycle::findOrFail($id);
        
        // 檢查機車是否仍可預約
        if ($motorcycle->status !== 'available') {
            return redirect()->route('motorcycles.index')
                ->with('error', '此機車目前無法預約');
        }

        // 驗證表單資料
        $request->validate([
            'license_number' => 'required|string|max:20',
            'rent_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:rent_date',
            'notes' => 'nullable|string|max:500',
        ]);

        // 建立訂單
        $order = Order::create([
            'store_id' => $motorcycle->store_id,
            'member_id' => auth('member')->id(),
            'total_price' => $motorcycle->price * (strtotime($request->return_date) - strtotime($request->rent_date)) / (24 * 60 * 60),
            'rent_date' => $request->rent_date,
            'is_completed' => false,
        ]);

        // 建立訂單明細
        OrderDetail::create([
            'order_id' => $order->id,
            'motorcycle_id' => $motorcycle->id,
            'quantity' => 1,
            'subtotal' => $motorcycle->price * (strtotime($request->return_date) - strtotime($request->rent_date)) / (24 * 60 * 60),
            'total' => $motorcycle->price * (strtotime($request->return_date) - strtotime($request->rent_date)) / (24 * 60 * 60),
        ]);

        // 更新機車狀態為已出租
        $motorcycle->update(['status' => 'rented']);

        return redirect()->route('orders.index')
            ->with('success', '預約成功！您的訂單編號是：' . $order->id);
    }
}
