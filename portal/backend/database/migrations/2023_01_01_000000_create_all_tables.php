<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Users table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('first_name');
                $table->string('last_name');
                $table->timestamps();
            });
        }

        // Admin station table
        if (!Schema::hasTable('admin_station')) {
            Schema::create('admin_station', function (Blueprint $table) {
                $table->id();
                $table->string('username');
                $table->string('password');
                $table->string('role'); // SUPERADMIN, ADMIN
                $table->text('terminal_id')->nullable();
                $table->text('device_token')->nullable();
                $table->timestamps();
            });
        }

        // Ajo table
        if (!Schema::hasTable('ajo')) {
            Schema::create('ajo', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->dateTime('date');
                $table->enum('txn_type', ['CREDIT', 'DEBIT']);
                $table->string('amount');
                $table->string('bal_before')->nullable();
                $table->string('bal_after')->nullable();
                $table->boolean('is_charge')->default(false);
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        // Loan table
        if (!Schema::hasTable('loan')) {
            Schema::create('loan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('amount');
                $table->string('duration');
                $table->enum('loan_type', ['DEBITOR', 'CREDITOR']);
                $table->string('rate');
                $table->string('commission');
                $table->dateTime('disbursement_date');
                $table->dateTime('due_date');
                $table->text('collateral')->nullable();
                $table->string('status'); // NOT PAID, PAID
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        // Service room table
        if (!Schema::hasTable('service_room')) {
            Schema::create('service_room', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('room_no');
                $table->string('amount');
                $table->dateTime('checked_in');
                $table->dateTime('checked_out')->nullable();
                $table->string('duration');
                $table->string('total_charge');
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        // Expense history table
        if (!Schema::hasTable('expense_history')) {
            Schema::create('expense_history', function (Blueprint $table) {
                $table->id();
                $table->text('description');
                $table->dateTime('date');
                $table->string('amount');
                $table->unsignedBigInteger('admin_station');
                $table->foreign('admin_station')->references('id')->on('admin_station');
            });
        }

        // Transaction history table
        if (!Schema::hasTable('transaction_history')) {
            Schema::create('transaction_history', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_type');
                $table->string('amount');
                $table->string('status');
                $table->string('payer')->nullable();
                $table->string('payer_fi')->nullable();
                $table->string('payee')->nullable();
                $table->string('payee_fi')->nullable();
                $table->dateTime('transaction_time');
                $table->string('transaction_ref');
                $table->string('earnings');
                $table->string('terminal_id')->nullable();
                $table->text('comment');
                $table->string('report_type');
                $table->unsignedBigInteger('admin_station');
                $table->string('profit')->nullable();
                $table->foreign('admin_station')->references('id')->on('admin_station');
            });
        }

        // Activity log table
        if (!Schema::hasTable('activity_log')) {
            Schema::create('activity_log', function (Blueprint $table) {
                $table->id();
                $table->text('activity');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->dateTime('created_at');
                $table->foreign('user_id')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_log');
        Schema::dropIfExists('transaction_history');
        Schema::dropIfExists('expense_history');
        Schema::dropIfExists('service_room');
        Schema::dropIfExists('loan');
        Schema::dropIfExists('ajo');
        Schema::dropIfExists('admin_station');
        Schema::dropIfExists('users');
    }
}