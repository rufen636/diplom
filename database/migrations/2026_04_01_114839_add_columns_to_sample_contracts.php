<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sample_contracts', function (Blueprint $table) {
            // Добавляем новые поля
            $table->json('sections')->nullable()->after('version');
            $table->json('metadata')->nullable()->after('sections');
            $table->text('notes')->nullable()->after('metadata');

            // Удаляем старые поля (если они есть)
            $table->dropColumn([
                'preamble',
                'subject_of_contract',
                'rights',
                'payment_terms',
                'liability',
                'force_majeure',
                'dispute_resolution',
                'confidentiality',
                'other_conditions',
                'signatures_block',
                'clauses',
            ]);
        });
    }

    public function down()
    {
        Schema::table('sample_contracts', function (Blueprint $table) {
            $table->dropColumn(['sections', 'metadata', 'notes']);

            $table->text('preamble')->nullable();
            $table->text('subject_of_contract')->nullable();
            $table->text('rights')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('liability')->nullable();
            $table->text('force_majeure')->nullable();
            $table->text('dispute_resolution')->nullable();
            $table->text('confidentiality')->nullable();
            $table->text('other_conditions')->nullable();
            $table->text('signatures_block')->nullable();
            $table->text('clauses')->nullable();
        });
    }
};
