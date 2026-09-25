<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialLinksToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('facebook_url')->default('https://www.facebook.com/profile.php?id=61590280230384');
            $table->string('instagram_url')->default('https://www.instagram.com/jamwalmotorsandspares/');
            $table->string('twitter_url')->default('https://x.com/JamwalMotors/status/2103423129465065799');
            $table->string('youtube_url')->default('https://www.youtube.com/');
            $table->string('linkedin_url')->default('https://www.linkedin.com/in/jamwal-motors-and-spares-6b234a435/');
            $table->string('whatsapp_url')->default('https://wa.me/917006291696');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'facebook_url',
                'instagram_url',
                'twitter_url',
                'youtube_url',
                'linkedin_url',
                'whatsapp_url',
            ]);
        });
    }
}
