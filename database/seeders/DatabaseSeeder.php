<?php

namespace Database\Seeders;

use App\Models\Area;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'مدير',
            'موظف'
        ];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

        $admin = [
            'name' => 'Younes Belaabda',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123')
        ];

        $user = \App\Models\User::create($admin);
        $user->assignRole('مدير');

        $areas = [
            'الحدود الشمالية',
            'منطقة القصيم',
            'منطقة الرياض',
            'منطقة مكة',
            'منطقة عسير',
            'منطقة نجران',
            'منطقة الباحة',
            'منطقة جازان',
            'منطقة المدينة المنورة',
            'منطقة سكاكا الجوف',
            'الشرقية',
            'منطقة حائل',
            'دولة الكويت',
            'دولة الامارات',
            'دولة قطر',
            'دولة سلطنة عمان',
            'دولة البحرين',
        ];

        foreach($areas as $area){
            Area::create([
                'name' => $area
            ]);
        }

        $cities1 = [
            'الرياض',
            'عرعر',
            'رفحاء',
            'طريف',
        ];

        foreach($cities1 as $city){
            City::create([
                'name' => $city,
                'area_id' => 1
            ]);
        }
    }
}
