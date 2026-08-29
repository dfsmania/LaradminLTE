<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class VerifiableUser extends User implements MustVerifyEmail
{
    use MustVerifyEmailTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
}
