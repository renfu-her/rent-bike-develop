<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MotorcycleAccessory;
use App\Models\Store;
use App\Models\Member;
use App\Models\Motorcycle;
use App\Models\Order;
use App\Models\OrderDetail;

class MotorcycleRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Motorcycle Accessories
        $accessories = [
            ['model' => '安全帽', 'quantity' => 50, 'status' => '待出租'],
            ['model' => '雨衣', 'quantity' => 30, 'status' => '待出租'],
            ['model' => 'GPS導航', 'quantity' => 20, 'status' => '待出租'],
            ['model' => '手機架', 'quantity' => 40, 'status' => '待出租'],
            ['model' => '後箱', 'quantity' => 25, 'status' => '待出租'],
        ];

        foreach ($accessories as $accessory) {
            MotorcycleAccessory::create($accessory);
        }

        // Create Stores
        $stores = [
            [
                'name' => '台北車站店',
                'phone' => '02-1234-5678',
                'address' => '台北市中正區忠孝西路一段49號',
                'status' => 'active'
            ],
            [
                'name' => '西門町店',
                'phone' => '02-2345-6789',
                'address' => '台北市萬華區西寧南路50號',
                'status' => 'active'
            ],
            [
                'name' => '信義店',
                'phone' => '02-3456-7890',
                'address' => '台北市信義區松仁路100號',
                'status' => 'active'
            ],
        ];

        foreach ($stores as $store) {
            Store::create($store);
        }

        // Create Members
        $members = [
            [
                'name' => '張小明',
                'email' => 'zhang@example.com',
                'password' => Hash::make('password123'),
                'id_number' => 'A123456789',
                'phone' => '0912-345-678',
                'address' => '台北市大安區復興南路一段390號'
            ],
            [
                'name' => '李小華',
                'email' => 'li@example.com',
                'password' => Hash::make('password123'),
                'id_number' => 'B987654321',
                'phone' => '0923-456-789',
                'address' => '台北市信義區信義路五段7號'
            ],
            [
                'name' => '王小美',
                'email' => 'wang@example.com',
                'password' => Hash::make('password123'),
                'id_number' => 'C111222333',
                'phone' => '0934-567-890',
                'address' => '台北市中山區中山北路二段1號'
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }

        // Create Motorcycles
        $motorcycles = [
            [
                'store_id' => 1,
                'name' => 'YAMAHA 勁戰',
                'model' => 'CYGNUS-X 125',
                'accessories' => [1, 2, 3], // 安全帽, 雨衣, GPS導航
                'license_plate' => 'ABC-123',
                'price' => 800,
                'status' => 'available'
            ],
            [
                'store_id' => 1,
                'name' => 'SYM 新名流',
                'model' => 'NEW DINK 125',
                'accessories' => [1, 2, 4], // 安全帽, 雨衣, 手機架
                'license_plate' => 'DEF-456',
                'price' => 750,
                'status' => 'available'
            ],
            [
                'store_id' => 2,
                'name' => 'KYMCO 雷霆',
                'model' => 'RACING 150',
                'accessories' => [1, 2, 5], // 安全帽, 雨衣, 後箱
                'license_plate' => 'GHI-789',
                'price' => 900,
                'status' => 'rented'
            ],
            [
                'store_id' => 2,
                'name' => 'HONDA 新大眼',
                'model' => 'CB150R',
                'accessories' => [1, 3, 4], // 安全帽, GPS導航, 手機架
                'license_plate' => 'JKL-012',
                'price' => 1000,
                'status' => 'available'
            ],
            [
                'store_id' => 3,
                'name' => 'SUZUKI 小阿魯',
                'model' => 'GSX-R150',
                'accessories' => [1, 2, 3, 4], // 安全帽, 雨衣, GPS導航, 手機架
                'license_plate' => 'MNO-345',
                'price' => 1200,
                'status' => 'maintenance'
            ],
            [
                'store_id' => 3,
                'name' => 'PGO 彪虎',
                'model' => 'TIGRA 150',
                'accessories' => [1, 2, 5], // 安全帽, 雨衣, 後箱
                'license_plate' => 'PQR-678',
                'price' => 850,
                'status' => 'available'
            ],
        ];

        foreach ($motorcycles as $motorcycle) {
            Motorcycle::create($motorcycle);
        }

        // Create Orders
        $orders = [
            [
                'store_id' => 2,
                'member_id' => 1,
                'total_price' => 900,
                'rent_date' => now()->addDays(2),
                'is_completed' => true
            ],
            [
                'store_id' => 1,
                'member_id' => 2,
                'total_price' => 800,
                'rent_date' => now()->addDays(5),
                'is_completed' => false
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        // Create Order Details
        $orderDetails = [
            [
                'order_id' => 1,
                'motorcycle_id' => 3, // 雷霆
                'quantity' => 1,
                'subtotal' => 900,
                'total' => 900
            ],
            [
                'order_id' => 2,
                'motorcycle_id' => 1, // 勁戰
                'quantity' => 1,
                'subtotal' => 800,
                'total' => 800
            ],
        ];

        foreach ($orderDetails as $orderDetail) {
            OrderDetail::create($orderDetail);
        }
    }
}
