<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_by');
            $table->smallInteger('type')->comment('1 - like, 2 - comment');
            $table->string('text');
            $table->boolean('is_close')->default(false);
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->timestamps();


            $table->foreign('comment_id')
                ->on('comments_posts')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_by')
                ->on('users')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
