<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
        });

        $used = [];

        DB::table('teachers')->orderBy('id')->each(function ($teacher) use (&$used) {
            $base = $teacher->email
                ? Str::before($teacher->email, '@')
                : Str::slug($teacher->name ?: 'guru-' . $teacher->id);
            $base = $base ?: 'guru-' . $teacher->id;
            $username = $base;
            $counter = 2;

            while (in_array($username, $used, true)) {
                $username = $base . '-' . $counter;
                $counter++;
            }

            $used[] = $username;

            DB::table('teachers')
                ->where('id', $teacher->id)
                ->update(['username' => $username]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
