<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasCrudActions;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeachingJournalController extends Controller
{
    use HasCrudActions;

    protected string $model = TeachingJournal::class;
    protected string $title = 'Jurnal Mengajar';
    protected string $routePrefix = 'guru.journals';

    protected function fields(): array
    {
        return [
            'date' => ['label' => 'Tanggal', 'type' => 'date'],
            'teacher_id' => ['label' => 'Guru', 'type' => 'select', 'options' => Teacher::pluck('name', 'id')->toArray()],
            'school_class_id' => ['label' => 'Kelas', 'type' => 'select', 'options' => SchoolClass::pluck('name', 'id')->toArray()],
            'subject_id' => ['label' => 'Mata Pelajaran', 'type' => 'select', 'options' => Subject::pluck('name', 'id')->toArray()],
            'lesson_hour' => ['label' => 'Jam Pelajaran', 'type' => 'number'],
            'material' => ['label' => 'Materi', 'type' => 'textarea'],
            'method' => ['label' => 'Metode', 'type' => 'text'],
            'present_count' => ['label' => 'Hadir', 'type' => 'number'],
            'sick_count' => ['label' => 'Sakit', 'type' => 'number'],
            'permission_count' => ['label' => 'Izin', 'type' => 'number'],
            'absent_count' => ['label' => 'Alfa', 'type' => 'number'],
            'status' => ['label' => 'Status', 'type' => 'select', 'options' => ['draft' => 'Draft', 'submitted' => 'Terkirim', 'reviewed' => 'Direview']],
        ];
    }

    protected function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'lesson_hour' => ['required', 'integer', 'min:1', 'max:12'],
            'material' => ['nullable', 'string'],
            'method' => ['nullable', 'string', 'max:120'],
            'present_count' => ['nullable', 'integer', 'min:0'],
            'sick_count' => ['nullable', 'integer', 'min:0'],
            'permission_count' => ['nullable', 'integer', 'min:0'],
            'absent_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'max:40'],
        ];
    }

    public function store(Request $request)
    {
        if ($request->has('tanggal')) {
            $teacher = $request->filled('guru') ? Teacher::firstOrCreate(['name' => $request->input('guru')]) : null;
            $class = $request->filled('kelas') ? SchoolClass::firstOrCreate(['name' => $request->input('kelas')]) : null;
            $subject = $request->filled('mapel') ? Subject::firstOrCreate(['name' => $request->input('mapel')]) : null;

            $attendance = ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0];
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'absen_') && isset($attendance[$value])) {
                    $attendance[$value]++;
                }
            }

            TeachingJournal::create([
                'date' => $request->validate([
                    'tanggal' => ['required', 'date'],
                    'jam_pelajaran' => ['required', 'integer', 'min:1', 'max:12'],
                    'guru' => ['required', 'string', 'max:255'],
                    'kelas' => ['required', 'string', 'max:120'],
                    'mapel' => ['required', 'string', 'max:120'],
                    'materi' => ['nullable', 'string'],
                    'metode' => ['nullable', 'string', 'max:120'],
                ])['tanggal'],
                'lesson_hour' => $request->integer('jam_pelajaran'),
                'teacher_id' => $teacher?->id,
                'school_class_id' => $class?->id,
                'subject_id' => $subject?->id,
                'material' => $request->input('materi'),
                'method' => $request->input('metode'),
                'present_count' => $attendance['H'],
                'sick_count' => $attendance['S'],
                'permission_count' => $attendance['I'],
                'absent_count' => $attendance['A'],
                'status' => 'submitted',
            ]);

            return redirect()->route('guru.input-jurnal')->with('success', 'Jurnal mengajar berhasil disimpan.');
        }

        return $this->storeCrud($request);
    }

    protected function storeCrud(Request $request)
    {
        TeachingJournal::create($request->validate($this->rules()));

        return redirect()->route($this->routePrefix . '.index')->with('success', $this->title . ' berhasil ditambahkan.');
    }

    public function export(): Response
    {
        $rows = TeachingJournal::with(['teacher', 'schoolClass', 'subject'])->latest()->get();
        $csv = "Guru,Tanggal,Jam,Kelas,Mata Pelajaran,Materi,Metode,Hadir,Sakit,Izin,Alfa,Status\n";

        foreach ($rows as $journal) {
            $csv .= implode(',', array_map(fn ($value) => '"' . str_replace('"', '""', (string) $value) . '"', [
                $journal->teacher?->name,
                optional($journal->date)->format('Y-m-d'),
                $journal->lesson_hour,
                $journal->schoolClass?->name,
                $journal->subject?->name,
                $journal->material,
                $journal->method,
                $journal->present_count,
                $journal->sick_count,
                $journal->permission_count,
                $journal->absent_count,
                $journal->status,
            ])) . "\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="jurnal-mengajar.csv"',
        ]);
    }
}
