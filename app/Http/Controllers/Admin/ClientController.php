<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class ClientController extends CrudController
{
    protected string $model = Client::class;
    protected string $route = 'clients';
    protected string $title = 'Clients';
    protected string $singular = 'Client';

    protected function columns(): array
    {
        return [
            ['key' => 'logo', 'label' => 'Logo', 'type' => 'image'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'website', 'label' => 'Website'],
            ['key' => 'is_active', 'label' => 'Active', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Client name'],
            'website' => ['label' => 'Website (optional)', 'type' => 'url'],
            'logo' => ['label' => 'Logo (optional)', 'type' => 'image'],
            'sort_order' => ['label' => 'Display order', 'type' => 'number', 'default' => 0],
            'is_active' => ['label' => 'Show on website', 'type' => 'checkbox', 'default' => true],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'name' => 'required|string|max:160',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];
    }
}
