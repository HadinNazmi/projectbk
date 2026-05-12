@extends('layout')
@section('title', ($item->exists ? 'Edit ' : 'Tambah ') . $title)

@section('content')
<div class="hero hero-spaced">
    <div class="hero-left">
        <div class="hero-icon">
            <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
        </div>
        <h1>{{ $item->exists ? 'Edit' : 'Tambah' }} {{ $title }}</h1>
        <p>Lengkapi data berikut, lalu simpan perubahan.</p>
    </div>
    <a href="{{ route($routePrefix . '.index') }}" class="btn btn-outline">Kembali</a>
</div>

@if($errors->any())
    <div class="card card-error">
        <strong>Periksa kembali input:</strong>
        <div class="mt-soft">{{ $errors->first() }}</div>
    </div>
@endif

<form class="card" action="{{ $item->exists ? route($routePrefix . '.update', $item) : route($routePrefix . '.store') }}" method="POST">
    @csrf
    @if($item->exists)
        @method('PUT')
    @endif
    <div class="card-head">
        <h3>Form {{ $title }}</h3>
    </div>
    <div class="card-body">
        <div class="form-row cols-2">
            @foreach($fields as $name => $field)
                <div class="form-group {{ ($field['type'] ?? 'text') === 'textarea' ? 'full' : '' }}">
                    <label for="{{ $name }}">{{ $field['label'] }}</label>
                    @if(($field['type'] ?? 'text') === 'select')
                        <select class="form-control" id="{{ $name }}" name="{{ $name }}">
                            <option value="">Pilih {{ strtolower($field['label']) }}</option>
                            @foreach(($field['options'] ?? []) as $value => $label)
                                <option value="{{ $value }}" @selected(old($name, data_get($item, $name)) == $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    @elseif(($field['type'] ?? 'text') === 'textarea')
                        <textarea class="form-control" id="{{ $name }}" name="{{ $name }}">{{ old($name, data_get($item, $name)) }}</textarea>
                    @else
                        <input class="form-control" id="{{ $name }}" name="{{ $name }}" type="{{ $field['type'] ?? 'text' }}" value="{{ old($name, data_get($item, $name)) }}">
                    @endif
                </div>
            @endforeach
        </div>
        <div class="btn-row">
            <button class="btn btn-primary btn-full" type="submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                Simpan
            </button>
            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </div>
</form>
@endsection
