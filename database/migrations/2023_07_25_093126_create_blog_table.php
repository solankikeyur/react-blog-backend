<?php

use App\Models\Blog;
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
        $blog = new Blog();
        Schema::create($blog->getTable(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->string("title");
            $table->longText("short_description");
            $table->longText("content");
            $table->string("image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $blog = new Blog();
        Schema::table($blog->getTable(), function(Blueprint $table) {
            $table->dropForeign(["user_id"]);
        });
        Schema::dropIfExists($blog->getTable());
    }
};
