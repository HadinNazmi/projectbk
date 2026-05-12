<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasCrudActions;
use App\Models\SchoolClass;
use App\Models\Student;

class StudentController extends Controller
{
    use HasCrudActions;

    protected string $model = Student::class;
    protected string $title = 'Siswa';
    protected string $routePrefix = 'admin.students';

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama Siswa', 'type' => 'text'],
            'nisn' => ['label' => 'NISN', 'type' => 'text'],
            'school_class_id' => ['label' => 'Kelas', 'type' => 'select', 'options' => SchoolClass::pluck('name', 'id')->toArray()],
            'gender' => ['label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['L' => 'Laki-laki', 'P' => 'Perempuan']],
            'guardian_name' => ['label' => 'Wali Murid', 'type' => 'text'],
            'status' => ['label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Aktif', 'inactive' => 'Nonaktif']],
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nisn' => ['nullable', 'string', 'max:80'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'gender' => ['nullable', 'string', 'max:20'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
        ];
    }
}
