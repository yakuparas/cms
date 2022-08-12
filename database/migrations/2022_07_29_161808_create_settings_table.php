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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('title',100)->nullable();
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->string('company',100)->nullable();
            $table->string('phone',30)->nullable();
            $table->string('mobile',30)->nullable();
            $table->string('fax',30)->nullable();
            $table->string('email',30)->nullable();
            $table->string('facebook',255)->nullable();
            $table->string('instagram',255)->nullable();
            $table->string('twitter',255)->nullable();
            $table->string('youtube',255)->nullable();
            $table->string('linkedin',255)->nullable();
            $table->string('googleSecret',255)->nullable();
            $table->string('facebookSecret',255)->nullable();
            $table->string('instagramSecret',255)->nullable();
            $table->string('linkedinSecret',255)->nullable();
            $table->longText('maps')->nullable();
            $table->longText('analytics')->nullable();
            $table->string('smtpserver',100)->nullable();
            $table->string('smtpemail',100)->nullable();
            $table->string('smtppassword')->nullable();
            $table->string('smtpport',5)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
