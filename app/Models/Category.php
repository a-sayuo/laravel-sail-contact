<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Category extends Model
{
    protected $fillable = ['name'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}