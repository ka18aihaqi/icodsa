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
        Schema::create('letter_of_acceptances', function (Blueprint $table) {
            $table->id();
            $table->text('author_name');
            $table->text('institution');
            $table->text('email');
            $table->string('conference_title');
            $table->string('paper_id')->unique();
            $table->string('paper_title');
            $table->string('issued_at');
            $table->enum('status', ['Accepted', 'Rejected']);
            $table->text('signature')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_of_acceptances');
    }
};
