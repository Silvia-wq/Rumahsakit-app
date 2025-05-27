<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jadwalpoliklinik', 50);
            $table->bigInteger('kode_antrian')->nullable()->unique();
            $table->integer('no_antrian');
            $table->string('nama_pasien');
            $table->string('no_telp')->nullable();
            $table->foreignId('jadwalpoliklinik_id')->constrained('jadwalpoliklinik')->onDelete('cascade');
            $table->foreignId('id_pasien')->constrained('datapasien');
            $table->unsignedBigInteger('dokter_id')->nullable();
            $table->string('nama_dokter');
            $table->string('poliklinik');
            $table->string('penjamin');
            $table->string('no_kbpjs')->nullable();
            $table->string('scan_kbpjs')->nullable();
            $table->string('scan_kasuransi')->nullable();
            $table->date('tanggal_berobat');
            $table->date('tanggal_reservasi');
            $table->string('scan_surat_rujukan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('user');
            $table->timestamps();
        });

               // Convert any existing values to string format for kode_jadwalpoliklinik
               DB::statement('UPDATE antrian 
               SET kode_jadwalpoliklinik = CONCAT("JP-", LPAD(id, 8, "0")) 
               WHERE kode_jadwalpoliklinik IS NULL OR kode_jadwalpoliklinik = "" 
               OR kode_jadwalpoliklinik NOT LIKE "JP-%"');
           
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrian');
    }
};