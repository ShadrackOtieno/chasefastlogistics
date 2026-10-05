<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rate;
use Illuminate\Database\Eloquent\Model;

class RateController extends CrudController
{
    protected string $model = Rate::class;
    protected string $route = 'rates';
    protected string $title = 'Rates';
    protected string $singular = 'Rate';

    protected function columns(): array
    {
        return [
            ['key' => 'category', 'label' => 'Group'],
            ['key' => 'item', 'label' => 'Item'],
            ['key' => 'amount', 'label' => 'Amount (KES)', 'type' => 'money'],
            ['key' => 'unit', 'label' => 'Unit'],
            ['key' => 'is_active', 'label' => 'Active', 'type' => 'bool'],
        ];
    }

    protected function query()
    {
        return Rate::query()->orderBy('category')->orderBy('sort_order')->orderBy('id');
    }

    protected function fields(): array
    {
        return [
            'category' => ['label' => 'Group heading', 'help' => 'Rates with the same heading appear together, e.g. "Air Freight".'],
            'item' => ['label' => 'Item'],
            'amount' => ['label' => 'Amount (KES)', 'type' => 'number', 'step' => '0.01'],
            'unit' => ['label' => 'Unit', 'help' => 'e.g. per shipment, per kg, per container'],
            'note' => ['label' => 'Note (optional)', 'wide' => true],
            'sort_order' => ['label' => 'Display order', 'type' => 'number', 'default' => 0],
            'is_active' => ['label' => 'Show on website', 'type' => 'checkbox', 'default' => true],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'category' => 'required|string|max:160',
            'item' => 'required|string|max:200',
            'amount' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:60',
            'note' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];
    }
}
