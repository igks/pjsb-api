<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['level', 'chapter', 'title'];

    public static function rules($fields = [])
    {
        return array_merge([
            'level' => 'required',
            'chapter' => 'required',
            'title' => 'required'
        ], $fields);
    }

    public function details()
    {
        return $this->hasMany(ContentDetail::class);
    }
}
