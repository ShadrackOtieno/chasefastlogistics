<?php

namespace App\Http\Controllers\Admin;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Model;

class TeamController extends CrudController
{
    protected string $model = TeamMember::class;
    protected string $route = 'team';
    protected string $title = 'Team';
    protected string $singular = 'Team member';

    protected function columns(): array
    {
        return [
            ['key' => 'photo', 'label' => 'Photo', 'type' => 'image'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'title', 'label' => 'Position'],
            ['key' => 'phone', 'label' => 'Phone'],
            ['key' => 'is_active', 'label' => 'Active', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            'name' => ['label' => 'Full name'],
            'title' => ['label' => 'Position'],
            'phone' => ['label' => 'Phone'],
            'email' => ['label' => 'Email', 'type' => 'email'],
            'bio' => ['label' => 'Short bio (optional)', 'type' => 'textarea', 'wide' => true, 'rows' => 4],
            'photo' => ['label' => 'Photo (optional)', 'type' => 'image'],
            'sort_order' => ['label' => 'Display order', 'type' => 'number', 'default' => 0],
            'is_active' => ['label' => 'Show on website', 'type' => 'checkbox', 'default' => true],
        ];
    }

    protected function rules(?Model $item): array
    {
        return [
            'name' => 'required|string|max:120',
            'title' => 'required|string|max:120',
            'phone' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:160',
            'bio' => 'nullable|string|max:2000',
            'photo' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable',
        ];
    }
}
