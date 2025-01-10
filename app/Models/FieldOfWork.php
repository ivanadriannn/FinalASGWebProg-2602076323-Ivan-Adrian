<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldOfWork extends Model
{
    use HasFactory;

    protected $table = 'field_of_works';

    protected $guarded = ['id'];
    
    public function userFields()
    {
        return $this->hasMany(UserField::class);
    }
}
