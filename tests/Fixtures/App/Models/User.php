<?php

namespace App\Models;

use DFSmania\LaradminLte\Models\Concerns\HasProfileImage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasProfileImage;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function tokens(): object
    {
        return new class
        {
            public function delete(): void {}
        };
    }
}
