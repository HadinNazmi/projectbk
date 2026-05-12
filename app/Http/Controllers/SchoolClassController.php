<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasCrudActions;
use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    use HasCrudActions;

    protected string $model = SchoolClass::class;
    protected string $title = 'Kelas';
    protected string $routePrefix = 'admin.classes';

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama Kelas', 'type' => 'text'],
            'grade' => ['label' => 'Tingkat', 'type' => 'text'],
            'homeroom_teacher' => ['label' => 'Wali Kelas', 'type' => 'text'],
            'capacity' => ['label' => 'Kapasitas', 'type' => 'number'],
            'status' => ['label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Aktif', 'inactive' => 'Nonaktif']],
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'grade' => ['nullable', 'string', 'max:80'],
            'homeroom_teacher' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:40'],
        ];
    }
}
