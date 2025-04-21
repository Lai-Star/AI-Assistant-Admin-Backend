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
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id(); // id (Primary Key)
            $table->string('name');
            $table->unsignedBigInteger('company_id')->nullable(); // Foreign key
            $table->integer('member_cnt')->default(0); // Optional: default to 0
            $table->unsignedBigInteger('created_by')->nullable(); // Foreign key
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_groups');
    }
};
