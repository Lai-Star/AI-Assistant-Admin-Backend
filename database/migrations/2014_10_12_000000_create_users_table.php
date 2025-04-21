<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id (Primary Key)
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // Using enum type
            $table->enum('role', array_column(UserRole::cases(), 'value'))
                  ->default(UserRole::Member->value);

            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_group_id')->nullable();
            $table->timestamps();

            // Foreign keys (optional but good practice)
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            // $table->foreign('user_group_id')->references('id')->on('user_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
