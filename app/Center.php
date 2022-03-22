<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    protected $table = 'centro';
    protected $key = 'ID';

    public $timestamps = false;

    // SCOPE
    /**
     * Method scopeActive
     *
     * @param $query $query [explicite description]
     *
     * @return void
     */
    public function scopeActive($query)
    {
        return $query->where('ACTIVO', true);
    }

    /**
     * Get all of the comments for the Center
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'IDCENTRO', 'ID');
    }


}
