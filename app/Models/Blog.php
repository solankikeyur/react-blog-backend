<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $table = "blog";

    protected $fillable = [
        "user_id",
        "title",
        "short_description",
        "content",
        "image",
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("d M, Y", strtotime($value)),
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk("public")->exists($value) ? asset('storage/'.$value) : null,
        );
    }

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }
}
