<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PruneProductsTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['visited_count', 'last_visited_at', 'review_stars', 'review_details']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('visited_count')->unsigned()->default(0);
            $table->timestamp('last_visited_at')->nullable();
            $table->integer('review_stars')->unsigned()->default(0);
            $table->text('review_details')->nullable();
        });
    }
}
