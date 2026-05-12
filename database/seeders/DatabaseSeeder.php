<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $school = School::firstOrCreate(
            ['npsn' => '10403921'],
            [
                'name' => 'MTsN 3 Pekanbaru',
                'city' => 'Pekanbaru',
                'level' => 'SMP/MTs',
                'principal_name' => 'Kepala MTsN 3 Pekanbaru',
                'admin_email' => 'admin@mtsn3.test',
                'status' => 'verified',
                'verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'superadmin@sistem.test'],
            ['name' => 'Super Admin', 'username' => 'superadmin', 'password' => 'password', 'role' => 'super-admin', 'status' => 'active']
        );

        User::updateOrCreate(
            ['email' => 'admin@mtsn3.test'],
            ['name' => 'Admin Sekolah', 'username' => 'admin', 'password' => 'password', 'role' => 'admin', 'school_id' => $school->id, 'status' => 'active']
        );

        $teacher = Teacher::updateOrCreate(
            ['nip' => '1987654321'],
            [
                'school_id' => $school->id,
                'name' => 'Guru Pengajar',
                'username' => '1987654321',
                'nip' => '1987654321',
                'email' => 'guru@mtsn3.test',
                'phone' => '081234567890',
                'subject' => 'Matematika',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['teacher_id' => $teacher->id],
            [
                'name' => $teacher->name,
                'username' => $teacher->nip,
                'email' => $teacher->email ?: 'guru-' . $teacher->id . '@sistem.local',
                'password' => $teacher->nip,
                'role' => 'guru',
                'school_id' => $school->id,
                'teacher_id' => $teacher->id,
                'status' => 'active',
            ]
        );
    }
}
