<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $t) {
            $t->id();
            $t->string('tracking_number')->unique();
            $t->string('customer_name');
            $t->string('customer_email')->nullable();
            $t->string('mode')->default('sea');
            $t->string('origin');
            $t->string('destination');
            $t->string('description')->nullable();
            $t->string('status')->default('booked');
            $t->string('current_location')->nullable();
            $t->date('eta')->nullable();
            $t->timestamps();
        });

        Schema::create('shipment_events', function (Blueprint $t) {
            $t->id();
            $t->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $t->string('status');
            $t->string('location')->nullable();
            $t->string('note')->nullable();
            $t->timestamp('occurred_at');
            $t->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $t) {
            $t->id();
            $t->string('reference')->unique();
            $t->string('name');
            $t->string('company')->nullable();
            $t->string('email');
            $t->string('phone');
            $t->string('service_type');
            $t->string('origin');
            $t->string('destination');
            $t->text('cargo_description');
            $t->string('weight')->nullable();
            $t->string('container_type')->nullable();
            $t->text('message')->nullable();
            $t->string('status')->default('new');
            $t->text('admin_notes')->nullable();
            $t->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('phone')->nullable();
            $t->string('subject');
            $t->text('message');
            $t->boolean('is_read')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['contact_messages', 'quote_requests', 'shipment_events', 'shipments'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
