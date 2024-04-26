<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Sulistiya Nugroho',
                'email' => 'sulis.nugroho@inlingua.co.id',
                'password' => Hash::make('semangat45'),
                'user_level'    => 0,
                'created_at'   => date('Y-m-d'),
                'updated_at'   => date('Y-m-d'),
            ],
            [
                'id' => 2,
                'name' => 'Isnaini Nur Pramesty',
                'email' => 'pramesnain@gmail.com',
                'password' => Hash::make('semangat45'),
                'user_level'    => 1,
                'created_at'   => date('Y-m-d'),
                'updated_at'   => date('Y-m-d'),
            ]
        ];
        DB::table('users')->insert($users);
        $employee = [
            [
                'id_employee' => 1,
                'id_users'  => 1,
                'personal_email' => 'sulisgor.a@gmail.com',
                'emp_position'  => 'IT',
                'emp_division'  => 'Operational',
                'place_birth'   => 'Jakarta',
                'birth_date'    => '1999-04-20',
                'sex'   => 'Laki - Laki',
                'nik'   => '',
                'npwp'   => '',
                'bank_acc'   => '',
                'bpjs_kes'   => '',
                'bpjs_ket'   => '',
                'date_joined'   => '2020-8-21',
                'status_kontrak'   => 'kontrak',
                'status_nikah'   => 'Single',
                'emp_address'   => 'Tangerang',
                'emp_phone'   => '082110873602',
                'emp_phone_emergency'   => '082110873601',
                'created_at'   => date('Y-m-d'),
                'updated_at'   => date('Y-m-d'),
            ],
            [
                'id_employee' => 2,
                'id_users'  => 2,
                'personal_email' => 'pramesnain@gmail.com',
                'emp_position'  => 'Staff',
                'emp_division'  => 'Operational',
                'place_birth'   => 'Jakarta',
                'birth_date'    => '1999-08-02',
                'sex'   => 'Perempuan',
                'nik'   => '',
                'npwp'   => '',
                'bank_acc'   => '',
                'bpjs_kes'   => '',
                'bpjs_ket'   => '',
                'date_joined'   => '2021-10-1',
                'status_kontrak'   => 'kontrak',
                'status_nikah'   => 'Single',
                'emp_address'   => 'Tangerang',
                'emp_phone'   => '085711250060',
                'emp_phone_emergency'   => '085711250062',
                'created_at'   => date('Y-m-d'),
                'updated_at'   => date('Y-m-d'),
            ]
        ];
        DB::table('employee')->insert($employee);
    }
}
