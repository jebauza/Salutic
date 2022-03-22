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

    protected $appends = ['fullName'];

    // Attributes
    function getFullNameAttribute()
    {
        return trim(($this->NOMBRE ? $this->NOMBRE . ' ' : '') . ($this->APELLIDO1 ? $this->APELLIDO1 . ' ' : '') . ($this->APELLIDO2 ? $this->APELLIDO2 . ' ' : ''));
    }

    /**
     * Get the password for the user.
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->attributes[$this->activePasswordIndex()];
    }

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'IDCENTRO', 'ID');
    }

    /**
     * Method activePassword
     *
     * @return String or null $activePassword
     */
    public function activePassword()
    {
        switch ($this->INDEXPASSWORD) {
            case 1:
                $activePassword = $this->PASSWORD;
                break;

            case 2:
                $activePassword = $this->PASSWORD2;
                break;

            case 3:
                $activePassword = $this->PASSWORD3;
                break;

            case 4:
                $activePassword = $this->PASSWORD4;
                break;

            case 5:
                $activePassword = $this->PASSWORD5;
                break;

            default:
                $activePassword = null;
                break;
        }

        return $activePassword;
    }


    /**
     * Method activePasswordIndex
     *
     * @return void
     */
    public function activePasswordIndex()
    {
        switch ($this->INDEXPASSWORD) {
            case 1:
                $activePasswordIndex = 'PASSWORD';
                break;

            case 2:
                $activePasswordIndex = 'PASSWORD2';
                break;

            case 3:
                $activePasswordIndex = 'PASSWORD3';
                break;

            case 4:
                $activePasswordIndex = 'PASSWORD4';
                break;

            case 5:
                $activePasswordIndex = 'PASSWORD5';
                break;

            default:
                $activePasswordIndex = null;
                break;
        }

        return $activePasswordIndex;
    }
}
