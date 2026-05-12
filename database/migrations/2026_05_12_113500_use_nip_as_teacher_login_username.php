<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('teachers')
            ->whereNotNull('nip')
            ->orderBy('id')
            ->each(function ($teacher) {
                DB::table('teachers')
                    ->where('id', $teacher->id)
                    ->update(['username' => $teacher->nip]);

                DB::table('users')
                    ->where('teacher_id', $teacher->id)
                    ->where('role', 'guru')
                    ->update(['username' => $teacher->nip]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('teachers')
            ->whereNotNull('email')
            ->orderBy('id')
            ->each(function ($teacher) {
                $username = str($teacher->email)->before('@')->toString();

                DB::table('teachers')
                    ->where('id', $teacher->id)
                    ->update(['username' => $username]);

                DB::table('users')
                    ->where('teacher_id', $teacher->id)
                    ->where('role', 'guru')
                    ->update(['username' => $username]);
            });
    }
};
