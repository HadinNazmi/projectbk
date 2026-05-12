<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasCrudActions;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    use HasCrudActions;

    protected string $model = Teacher::class;
    protected string $title = 'Guru';
    protected string $routePrefix = 'admin.teachers';

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Nama Guru', 'type' => 'text'],
            'nip' => ['label' => 'NIP / Username & Password Awal', 'type' => 'text'],
            'phone' => ['label' => 'No. HP', 'type' => 'text'],
            'subject' => ['label' => 'Mapel Utama', 'type' => 'text'],
            'status' => ['label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Aktif', 'inactive' => 'Nonaktif']],
        ];
    }

    protected function rules(?string $id = null): array
    {
        $teacher = $id ? Teacher::with('user')->find($id) : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'nip' => [
                'required',
                'string',
                'max:80',
                'alpha_dash',
                Rule::unique('teachers', 'nip')->ignore($id),
                Rule::unique('users', 'username')->ignore($teacher?->user?->id),
            ],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'string', 'max:40'],
        ];
    }

    public function index()
    {
        $items = Teacher::where('school_id', auth()->user()->school_id)->latest()->paginate(10);

        return view('crud.index', $this->viewData(compact('items')));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['school_id'] = auth()->user()->school_id;

        $teacher = Teacher::create($data);
        $this->syncGuruAccount($teacher);

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Guru berhasil ditambahkan dan akun login guru sudah dibuat.');
    }

    public function edit(string $id)
    {
        $item = $this->findTeacherForCurrentSchool($id);

        return view('crud.form', $this->viewData(compact('item')));
    }

    public function update(Request $request, string $id)
    {
        $teacher = $this->findTeacherForCurrentSchool($id);
        $data = $request->validate($this->rules($id));
        $data['school_id'] = $teacher->school_id ?: auth()->user()->school_id;

        $teacher->update($data);
        $this->syncGuruAccount($teacher->fresh());

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Guru berhasil diperbarui dan akun login guru ikut disesuaikan.');
    }

    public function destroy(string $id)
    {
        $teacher = $this->findTeacherForCurrentSchool($id);
        $teacher->user?->delete();
        $teacher->delete();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Guru dan akun loginnya berhasil dihapus.');
    }

    private function syncGuruAccount(Teacher $teacher): void
    {
        $user = User::firstOrNew(['teacher_id' => $teacher->id]);

        $user->fill([
            'name' => $teacher->name,
            'username' => $teacher->nip,
            'email' => $teacher->email ?: 'guru-' . $teacher->id . '@sistem.local',
            'role' => 'guru',
            'school_id' => $teacher->school_id,
            'status' => $teacher->status === 'active' ? 'active' : 'inactive',
        ]);

        if (! $user->exists || ! $user->password_changed_at) {
            $user->password = $teacher->nip;
        }

        $user->save();
    }

    private function findTeacherForCurrentSchool(string $id): Teacher
    {
        return Teacher::with('user')
            ->where('school_id', auth()->user()->school_id)
            ->findOrFail($id);
    }
}
