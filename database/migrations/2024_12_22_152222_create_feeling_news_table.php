<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('feeling_news', function (Blueprint $table) {
            $table->unsignedBigInteger('new_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['new_id', 'user_id']);
            $table->tinyInteger('feeling');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at')->nullable();
            $table->unsignedTinyInteger('is_active')->nullable()->default(0)->comment('0');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeling_news');
    }
};
