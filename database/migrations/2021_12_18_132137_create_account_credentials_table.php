<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCredentialsTable extends Migration
{
    public function up()
    {
        Schema::create('account_credentials', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('account_id');

            $table->string('type');
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->index(['type']);
            $table->index(['type', 'username']);
        });
    }
}
