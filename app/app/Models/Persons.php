<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = ['name', 'surname', 'phone', 'emails'];
}
