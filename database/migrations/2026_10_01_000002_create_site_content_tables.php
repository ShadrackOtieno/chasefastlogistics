<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->text('value')->nullable();
            $t->timestamps();
        });

        Schema::create('services', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('category')->default('other');
            $t->string('icon')->nullable();
            $t->string('summary', 500);
            $t->text('body')->nullable();
            $t->text('features')->nullable();
            $t->string('image')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('rates', function (Blueprint $t) {
            $t->id();
            $t->string('category');
            $t->string('item');
            $t->decimal('amount', 12, 2)->nullable();
            $t->string('unit')->nullable();
            $t->string('note')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('clients', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('website')->nullable();
            $t->string('logo')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('team_members', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('title');
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->text('bio')->nullable();
            $t->string('photo')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['team_members', 'clients', 'rates', 'services', 'settings'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
