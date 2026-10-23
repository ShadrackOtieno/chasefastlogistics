<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Generic back-office CRUD. Child controllers only describe the model, the
 * list columns, the form fields and the validation rules.
 */
abstract class CrudController extends Controller
{
    protected string $model;
    protected string $route;     // e.g. "services" -> admin.services.*
    protected string $title;     // e.g. "Services"
    protected string $singular;  // e.g. "Service"

    abstract protected function columns(): array;
    abstract protected function fields(): array;
    abstract protected function rules(?Model $item): array;

    protected function query()
    {
        return ($this->model)::query()->orderBy('sort_order')->orderBy('id');
    }

    protected function prepare(array $data, ?Model $item): array
    {
        return $data;
    }

    public function index()
    {
        return view('admin.crud.index', [
            'items' => $this->query()->paginate(20),
            'columns' => $this->columns(),
            'route' => $this->route,
            'title' => $this->title,
            'singular' => $this->singular,
        ]);
    }

    public function create()
    {
        return $this->form(new $this->model);
    }

    public function edit($id)
    {
        return $this->form(($this->model)::findOrFail($id));
    }

    protected function form(Model $item)
    {
        return view('admin.crud.form', [
            'item' => $item,
            'fields' => $this->fields(),
            'route' => $this->route,
            'title' => $this->title,
            'singular' => $this->singular,
        ]);
    }

    public function store(Request $request)
    {
        ($this->model)::create($this->collect($request, null));
        return redirect()->route("admin.{$this->route}.index")->with('success', "{$this->singular} created.");
    }

    public function update(Request $request, $id)
    {
        $item = ($this->model)::findOrFail($id);
        $item->update($this->collect($request, $item));
        return redirect()->route("admin.{$this->route}.index")->with('success', "{$this->singular} updated.");
    }

    public function destroy($id)
    {
        $item = ($this->model)::findOrFail($id);
        foreach ($this->fields() as $name => $f) {
            if (($f['type'] ?? 'text') === 'image' && $item->{$name}) {
                Storage::disk('public')->delete($item->{$name});
            }
        }
        $item->delete();
        return redirect()->route("admin.{$this->route}.index")->with('success', "{$this->singular} deleted.");
    }

    protected function collect(Request $request, ?Model $item): array
    {
        $data = $request->validate($this->rules($item));

        foreach ($this->fields() as $name => $f) {
            $type = $f['type'] ?? 'text';
            if ($type === 'checkbox') {
                $data[$name] = $request->boolean($name);
            }
            if ($type === 'image') {
                unset($data[$name]);
                if ($request->hasFile($name)) {
                    if ($item && $item->{$name}) {
                        Storage::disk('public')->delete($item->{$name});
                    }
                    $data[$name] = $this->storeUpload($request->file($name));
                }
            }
        }
        if (array_key_exists('sort_order', $this->fields())) {
            $data['sort_order'] = $data['sort_order'] ?? 0;
        }

        return $this->prepare($data, $item);
    }

    /**
     * Store an uploaded file on the public disk.
     *
     * Normal path: uses Laravel's store() (detects the extension from the file
     * content, needs the PHP fileinfo extension).
     * Fallback: when fileinfo is missing, builds the filename from the
     * client-supplied extension, restricted to a safe allow-list, so uploads
     * keep working. Remove the fallback once fileinfo is enabled on the server.
     */
    protected function storeUpload(UploadedFile $file): string
    {
        if (class_exists('finfo')) {
            return $file->store($this->route, 'public');
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif', 'ico'];
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, $allowed, true)) {
            $ext = 'jpg';
        }

        return $file->storeAs($this->route, Str::random(40) . '.' . $ext, 'public');
    }
}
