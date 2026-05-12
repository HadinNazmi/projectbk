@extends('layout')
@section('title', 'Data ' . $title)

@section('content')
<div class="hero hero-spaced">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/></svg>
        </div>
        <h1>Data {{ $title }}</h1>
        <p>Kelola data {{ strtolower($title) }} melalui aksi tambah, ubah, dan hapus.</p>
    </div>
    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        Tambah Data
    </a>
</div>

@if(session('success'))
    <div class="card card-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-head card-head-between">
        <h3>Daftar {{ $title }}</h3>
        <span class="pill live">{{ $items->total() }} Data</span>
    </div>
    <div class="table-scroll">
        <table class="tbl">
            <thead>
                <tr>
                    @foreach($columns as $name => $field)
                        <th>{{ $field['label'] }}</th>
                    @endforeach
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        @foreach($columns as $name => $field)
                            @php($value = data_get($item, $name))
                            <td>{{ $field['options'][$value] ?? ($value instanceof \Illuminate\Support\Carbon ? $value->format('d M Y') : ($value ?? '-')) }}</td>
                        @endforeach
                        <td>
                            <div class="action-row">
                                <a href="{{ route($routePrefix . '.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route($routePrefix . '.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}">
                            <div class="tbl-empty">
                                <svg viewBox="0 0 24 24"><path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/></svg>
                                Belum ada data {{ strtolower($title) }}.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $items->links() }}
    </div>
</div>
@endsection
