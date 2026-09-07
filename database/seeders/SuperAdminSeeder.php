<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement("
            INSERT INTO users (name, email, password, role, company_id, created_at, updated_at)
            VALUES (
                'Super Admin',
                'superadmin@example.com',
                '\$2y\$12\$IkN3ZOBwM2BA3FAENHKhWORbdRuS4CSwafyGv1Yt6B7LtV1xeda2e',
                'SuperAdmin',
                NULL,
                NOW(),
                NOW()
            )
        ");
    }
}
