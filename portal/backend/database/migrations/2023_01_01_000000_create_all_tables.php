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
                $table->string('phone');
                $table->string('address');
                $table->string('service');
                $table->string('status');
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'first_name')) {
                    $table->string('first_name');
                }
                if (!Schema::hasColumn('users', 'last_name')) {
                    $table->string('last_name');
                }
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone');
                }
                if (!Schema::hasColumn('users', 'address')) {
                    $table->string('address');
                }
                if (!Schema::hasColumn('users', 'service')) {
                    $table->string('service');
                }
                if (!Schema::hasColumn('users', 'status')) {
                    $table->string('status');
                }
                if (!Schema::hasColumn('users', 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
                if (!Schema::hasColumn('users', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->softDeletes();
            });
        } else {
            Schema::table('admin_station', function (Blueprint $table) {
                if (!Schema::hasColumn('admin_station', 'username')) {
                    $table->string('username');
                }
                if (!Schema::hasColumn('admin_station', 'password')) {
                    $table->string('password');
                }
                if (!Schema::hasColumn('admin_station', 'role')) {
                    $table->string('role');
                }
                if (!Schema::hasColumn('admin_station', 'terminal_id')) {
                    $table->text('terminal_id')->nullable();
                }
                if (!Schema::hasColumn('admin_station', 'device_token')) {
                    $table->text('device_token')->nullable();
                }
                if (!Schema::hasColumn('admin_station', 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn('admin_station', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
                if (!Schema::hasColumn('admin_station', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->softDeletes();
            });
        } else {
            Schema::table('ajo', function (Blueprint $table) {
                if (!Schema::hasColumn('ajo', 'user_id')) {
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users');
                }
                if (!Schema::hasColumn('ajo', 'date')) {
                    $table->dateTime('date');
                }
                if (!Schema::hasColumn('ajo', 'txn_type')) {
                    $table->enum('txn_type', ['CREDIT', 'DEBIT']);
                }
                if (!Schema::hasColumn('ajo', 'amount')) {
                    $table->string('amount');
                }
                if (!Schema::hasColumn('ajo', 'bal_before')) {
                    $table->string('bal_before')->nullable();
                }
                if (!Schema::hasColumn('ajo', 'bal_after')) {
                    $table->string('bal_after')->nullable();
                }
                if (!Schema::hasColumn('ajo', 'is_charge')) {
                    $table->boolean('is_charge')->default(false);
                }
                if (!Schema::hasColumn('ajo', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->softDeletes();
            });
        } else {
            Schema::table('loan', function (Blueprint $table) {
                if (!Schema::hasColumn('loan', 'user_id')) {
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users');
                }
                if (!Schema::hasColumn('loan', 'amount')) {
                    $table->string('amount');
                }
                if (!Schema::hasColumn('loan', 'duration')) {
                    $table->string('duration');
                }
                if (!Schema::hasColumn('loan', 'loan_type')) {
                    $table->enum('loan_type', ['DEBITOR', 'CREDITOR']);
                }
                if (!Schema::hasColumn('loan', 'rate')) {
                    $table->string('rate');
                }
                if (!Schema::hasColumn('loan', 'commission')) {
                    $table->string('commission');
                }
                if (!Schema::hasColumn('loan', 'disbursement_date')) {
                    $table->dateTime('disbursement_date');
                }
                if (!Schema::hasColumn('loan', 'due_date')) {
                    $table->dateTime('due_date');
                }
                if (!Schema::hasColumn('loan', 'collateral')) {
                    $table->text('collateral')->nullable();
                }
                if (!Schema::hasColumn('loan', 'status')) {
                    $table->string('status');
                }
                if (!Schema::hasColumn('loan', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->string('has_checked_out')->default("false");
                $table->foreign('user_id')->references('id')->on('users');
                $table->softDeletes();
            });
        } else {
            Schema::table('service_room', function (Blueprint $table) {
                if (!Schema::hasColumn('service_room', 'user_id')) {
                    $table->unsignedBigInteger('user_id');
                    $table->foreign('user_id')->references('id')->on('users');
                }
                if (!Schema::hasColumn('service_room', 'room_no')) {
                    $table->string('room_no');
                }
                if (!Schema::hasColumn('service_room', 'amount')) {
                    $table->string('amount');
                }
                if (!Schema::hasColumn('service_room', 'checked_in')) {
                    $table->dateTime('checked_in');
                }
                if (!Schema::hasColumn('service_room', 'checked_out')) {
                    $table->dateTime('checked_out')->nullable();
                }
                if (!Schema::hasColumn('service_room', 'duration')) {
                    $table->string('duration');
                }
                if (!Schema::hasColumn('service_room', 'total_charge')) {
                    $table->string('total_charge');
                }

                if (!Schema::hasColumn('service_room', 'has_checked_out')) {
                    $table->string('has_checked_out')->default("false");
                }
                if (!Schema::hasColumn('service_room', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->softDeletes();
            });
        } else {
            Schema::table('expense_history', function (Blueprint $table) {
                if (!Schema::hasColumn('expense_history', 'description')) {
                    $table->text('description');
                }
                if (!Schema::hasColumn('expense_history', 'date')) {
                    $table->dateTime('date');
                }
                if (!Schema::hasColumn('expense_history', 'amount')) {
                    $table->string('amount');
                }
                if (!Schema::hasColumn('expense_history', 'admin_station')) {
                    $table->unsignedBigInteger('admin_station');
                    $table->foreign('admin_station')->references('id')->on('admin_station');
                }
                if (!Schema::hasColumn('expense_history', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->softDeletes();
            });
        } else {
            Schema::table('transaction_history', function (Blueprint $table) {
                if (!Schema::hasColumn('transaction_history', 'transaction_type')) {
                    $table->string('transaction_type');
                }
                if (!Schema::hasColumn('transaction_history', 'amount')) {
                    $table->string('amount');
                }
                if (!Schema::hasColumn('transaction_history', 'status')) {
                    $table->string('status');
                }
                if (!Schema::hasColumn('transaction_history', 'payer')) {
                    $table->string('payer')->nullable();
                }
                if (!Schema::hasColumn('transaction_history', 'payer_fi')) {
                    $table->string('payer_fi')->nullable();
                }
                if (!Schema::hasColumn('transaction_history', 'payee')) {
                    $table->string('payee')->nullable();
                }
                if (!Schema::hasColumn('transaction_history', 'payee_fi')) {
                    $table->string('payee_fi')->nullable();
                }
                if (!Schema::hasColumn('transaction_history', 'transaction_time')) {
                    $table->dateTime('transaction_time');
                }
                if (!Schema::hasColumn('transaction_history', 'transaction_ref')) {
                    $table->string('transaction_ref');
                }
                if (!Schema::hasColumn('transaction_history', 'earnings')) {
                    $table->string('earnings');
                }
                if (!Schema::hasColumn('transaction_history', 'terminal_id')) {
                    $table->string('terminal_id')->nullable();
                }
                if (!Schema::hasColumn('transaction_history', 'comment')) {
                    $table->text('comment');
                }
                if (!Schema::hasColumn('transaction_history', 'report_type')) {
                    $table->string('report_type');
                }
                if (!Schema::hasColumn('transaction_history', 'admin_station')) {
                    $table->unsignedBigInteger('admin_station');
                    $table->foreign('admin_station')->references('id')->on('admin_station');
                }
                if (!Schema::hasColumn('transaction_history', 'profit')) {
                    $table->string('profit')->nullable();
                }
                if (!Schema::hasColumn('transaction_history', 'deleted_at')) {
                    $table->softDeletes();
                }
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
                $table->softDeletes();
            });
        } else {
            Schema::table('activity_log', function (Blueprint $table) {
                if (!Schema::hasColumn('activity_log', 'activity')) {
                    $table->text('activity');
                }
                if (!Schema::hasColumn('activity_log', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable();
                    $table->foreign('user_id')->references('id')->on('users');
                }
                if (!Schema::hasColumn('activity_log', 'created_at')) {
                    $table->dateTime('created_at');
                }
                if (!Schema::hasColumn('activity_log', 'deleted_at')) {
                    $table->softDeletes();
                }
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