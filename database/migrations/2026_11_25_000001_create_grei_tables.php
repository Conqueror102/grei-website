<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('location');
            $table->string('city')->index();
            $table->string('category')->index();      // residential | commercial | land
            $table->string('listing_type')->index();  // sale | let | investment
            $table->unsignedBigInteger('price')->nullable(); // null = price on application
            $table->string('price_suffix')->nullable();      // e.g. "per annum"
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->unsignedInteger('area_sqm')->nullable();
            $table->string('summary', 500);
            $table->text('description');
            $table->json('features');
            $table->json('gallery');
            $table->boolean('featured')->default(false)->index();
            $table->string('status')->default('available'); // available | under_offer | sold
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('location');
            $table->string('sector')->index(); // residential | commercial | hospitality
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('area_sqm')->nullable();
            $table->string('summary', 500);
            $table->text('brief');
            $table->text('approach');
            $table->text('outcome');
            $table->json('scope');
            $table->json('gallery');
            $table->boolean('featured')->default(false)->index();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('stays', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('location');
            $table->string('city')->index();
            $table->string('type'); // Apartment | Penthouse | Villa | Studio
            $table->unsignedInteger('nightly_rate');
            $table->unsignedSmallInteger('min_nights')->default(1);
            $table->unsignedSmallInteger('max_guests');
            $table->unsignedSmallInteger('bedrooms');
            $table->unsignedSmallInteger('bathrooms');
            $table->string('summary', 500);
            $table->text('description');
            $table->json('amenities');
            $table->json('gallery');
            $table->string('check_in')->default('15:00');
            $table->string('check_out')->default('11:00');
            $table->boolean('featured')->default(false)->index();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index(); // general | property | interior | stay
            $table->nullableMorphs('subject');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('topic')->nullable();
            $table->text('message')->nullable();
            $table->json('meta')->nullable(); // dates, guests, quote, budget...
            $table->string('status')->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('stays');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('properties');
    }
};
