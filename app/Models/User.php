<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $table = 'users';

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function userFields()
    {
        return $this->hasMany(UserField::class);
    }

    public function friends()
    {
        return $this->hasMany(Friend::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function fields()
    {
        return $this->hasMany(UserField::class, 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
