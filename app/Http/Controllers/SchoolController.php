<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasCrudActions;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    use HasCrudActions;

    protected string $model = School::class;
    protected string $title = 'Sekolah';
    protected string $routePrefix = 'super-admin.schools';

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama Sekolah', 'type' => 'text'],
            'npsn' => ['label' => 'NPSN', 'type' => 'text'],
            'city' => ['label' => 'Kota/Kabupaten', 'type' => 'text'],
            'level' => ['label' => 'Jenjang', 'type' => 'select', 'options' => ['SD/MI' => 'SD/MI', 'SMP/MTs' => 'SMP/MTs', 'SMA/MA/SMK' => 'SMA/MA/SMK']],
            'principal_name' => ['label' => 'Kepala Sekolah', 'type' => 'text'],
            'admin_email' => ['label' => 'Email Admin', 'type' => 'email'],
            'status' => ['label' => 'Status', 'type' => 'select', 'options' => ['pending' => 'Menunggu', 'review' => 'Review', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak']],
            'address' => ['label' => 'Alamat', 'type' => 'textarea'],
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:120'],
            'level' => ['nullable', 'string', 'max:80'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'admin_email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'address' => ['nullable', 'string'],
        ];
    }

    public function approve(School $school)
    {
        $school->update([
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $username = $this->uniqueAdminUsername($school);
        $password = Str::password(10, letters: true, numbers: true, symbols: false, spaces: false);
        $email = $school->admin_email ?: 'admin-sekolah-' . $school->id . '@sistem.local';

        $admin = User::updateOrCreate(
            ['school_id' => $school->id, 'role' => 'admin'],
            [
                'name' => 'Admin ' . $school->name,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'status' => 'active',
            ]
        );

        return back()
            ->with('success', 'Sekolah berhasil disetujui dan akun admin berhasil dibuat.')
            ->with('admin_credentials', [
                'school' => $school->name,
                'username' => $admin->username,
                'password' => $password,
                'login_url' => route('login'),
            ]);
    }

    public function reject(School $school)
    {
        $school->update([
            'status' => 'rejected',
            'verified_at' => null,
        ]);

        return back()->with('success', 'Sekolah berhasil ditolak.');
    }

    public function export(): Response
    {
        $rows = School::latest()->get();
        $csv = "Nama Sekolah,NPSN,Kota,Jenjang,Kepala Sekolah,Email Admin,Status\n";

        foreach ($rows as $school) {
            $csv .= implode(',', array_map(fn ($value) => '"' . str_replace('"', '""', (string) $value) . '"', [
                $school->name,
                $school->npsn,
                $school->city,
                $school->level,
                $school->principal_name,
                $school->admin_email,
                $school->status,
            ])) . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="data-sekolah.csv"',
        ]);
    }

    private function uniqueAdminUsername(School $school): string
    {
        $base = Str::slug($school->npsn ?: $school->name, '');
        $base = $base ? 'admin' . $base : 'adminsekolah' . $school->id;
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)
            ->where(function ($query) use ($school) {
                $query->where('school_id', '!=', $school->id)->orWhereNull('school_id');
            })
            ->exists()) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }
}
