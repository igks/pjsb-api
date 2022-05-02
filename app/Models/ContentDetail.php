<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentDetail extends Model
{
    use HasFactory;

    protected $table = 'content_detail';
    protected $fillable = ['content_id', 'section', 'thumbnail', 'video_url', 'title'];

    public static function rules($fields = [])
    {
        return array_merge([
            'content_id' => 'required',
            'section' => 'required',
            'video_url' => 'required',
            'title' => 'required',
        ], $fields);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
