<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('nip');
            $table->string('jabatan'); // Perubahan di sini
            $table->string('photo');
            $table->dateTime('tanggal_absen');
            $table->string('keterangan')->nullable();
            $table->string('status')->default('Menunggu');
            $table->timestamps();

            // Definisikan foreign key untuk user_id yang mengacu ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absens');
    }
}
