<?php

namespace App;

use App\Center;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $key = 'ID';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'EMAIL',
        'NOMBRE',
        'APELLIDO1',
        'APELLIDO2',
        'TELEFONO1',
        'TELEFONO2',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'PASSWORD',
        'PASSWORD2',
        'PASSWORD3',
        'PASSWORD4',
        'PASSWORD5',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'IDCENTRO', 'ID');
    }
}
