<?php

namespace Database\Seeders;

use App\Models\PurchaseRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pr = PurchaseRequest::create([
            'pr_no' => 'PR-001',
            'job_number' => 'JOB-001',
        ]);
    }
}
