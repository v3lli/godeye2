<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
        use HasFactory;

        protected $fillable = ['title', 'subtitle', 'text', 'cover'];

        /**
         * Define the relationship: An album has many images.
         */
}

