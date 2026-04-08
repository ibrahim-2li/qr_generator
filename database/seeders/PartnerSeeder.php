<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            'name' => 'Google',
            'image'=> 'partners/Mo9o6NissYhXNnLjj2bN8m9Fpmakrv5Sy5FdUs1N.png',
            'url'  => 'https://google.com',
        ]);

        Partner::create([
            'name' => 'Sawaed',
            'image'=> 'partners/2optmHDIE4OhTcqnas2gy8IYZWBMVg0IQzmok6xe.png',
            'url'  => 'https://sawaed.com',
        ]);
        Partner::create([
            'name' => 'Fursan',
            'image'=> 'partners/8oIlcyqhS85c1ShWMy93DGbkEMsGVroIjoLTXSsq.png',
            'url'  => 'https://Fursan.com',
        ]);
        Partner::create([
            'name' => 'Mahasin',
            'image'=> 'partners/wovJX77cX1EENqAsO10OlqVnKnyIbWVHhaycgL7B.png',
            'url'  => 'https://Mahasin.com',
        ]);

         Partner::create([
            'name' => 'Qr',
            'image'=> 'partners/mHcwmTyH7KZ2eJtTXYMJddB0XPEQyJf50Sq72PIS.jpg',
            'url'  => 'https://qr.com',
        ]);
    }
}
