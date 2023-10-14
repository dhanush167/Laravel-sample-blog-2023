<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'slug'];

    protected $searchableFields = ['*'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
