<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserField extends Model
{
    use HasFactory;

    protected $table = 'user_fields';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fieldOfWork()
    {
        return $this->belongsTo(FieldOfWork::class, 'field_of_work_id');
    }
}
