<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_id')->nullable(); // For parent category relationship
            $table->string('brand');
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->text('description');
            $table->string('tag_number')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('price', 10, 2);
            // $table->string('sku')->unique()->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key relationships
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};