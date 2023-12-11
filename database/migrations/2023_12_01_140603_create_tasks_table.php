<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\frequencyType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->date('ini_date');
            $table->date('fin_date');
            $table->integer('interaction')->unsigned();
            $table->enum('frequency', ['diaria', 'mensual', 'anual'])->default(frequencyType::diaria->value);;
            $table->integer('week_day')->nullable()->default(0);
            $table->date('next_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
