<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idcb
 * @property string $cvc
 * @property string $codecb
 * @property string $anneeexp
 * @property string $moisexp
 * @property Client[] $clients
 */
class CB extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cb';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idcb';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['cvc', 'codecb', 'anneeexp', 'moisexp'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany('App\Models\Client', 'idcb', 'idcb');
    }
}
