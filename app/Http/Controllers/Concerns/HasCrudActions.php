<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait HasCrudActions
{
    public function index()
    {
        $items = $this->model::latest()->paginate(10);

        return view('crud.index', $this->viewData(compact('items')));
    }

    public function create()
    {
        $item = new $this->model;

        return view('crud.form', $this->viewData(compact('item')));
    }

    public function show(string $id)
    {
        return redirect()->route($this->routePrefix . '.edit', $id);
    }

    public function store(Request $request)
    {
        $this->model::create($request->validate($this->rules()));

        return redirect()->route($this->routePrefix . '.index')->with('success', $this->title . ' berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = $this->model::findOrFail($id);

        return view('crud.form', $this->viewData(compact('item')));
    }

    public function update(Request $request, string $id)
    {
        $item = $this->model::findOrFail($id);
        $item->update($request->validate($this->rules($id)));

        return redirect()->route($this->routePrefix . '.index')->with('success', $this->title . ' berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $this->model::findOrFail($id)->delete();

        return redirect()->route($this->routePrefix . '.index')->with('success', $this->title . ' berhasil dihapus.');
    }

    protected function viewData(array $extra = []): array
    {
        return array_merge([
            'title' => $this->title,
            'routePrefix' => $this->routePrefix,
            'fields' => $this->fields(),
            'columns' => $this->columns(),
        ], $extra);
    }

    protected function columns(): array
    {
        return $this->fields();
    }
}
