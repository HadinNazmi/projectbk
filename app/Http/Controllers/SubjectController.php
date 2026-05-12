<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasCrudActions;
use App\Models\Subject;

class SubjectController extends Controller
{
    use HasCrudActions;

    protected string $model = Subject::class;
    protected string $title = 'Mata Pelajaran';
    protected string $routePrefix = 'admin.subjects';

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama Mapel', 'type' => 'text'],
            'code' => ['label' => 'Kode', 'type' => 'text'],
            'weekly_hours' => ['label' => 'Jam/Minggu', 'type' => 'number'],
            'status' => ['label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Aktif', 'inactive' => 'Nonaktif']],
        ];
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'code' => ['nullable', 'string', 'max:40'],
            'weekly_hours' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:40'],
        ];
    }
}
