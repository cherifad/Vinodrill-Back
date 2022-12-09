<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idtypevisite
 * @property string $libelletypevisite
 * @property Visite[] $visites
 */
class Typevisite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'typevisite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idtypevisite';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['libelletypevisite'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visites()
    {
        return $this->hasMany('App\Models\Visite', 'idtypevisite', 'idtypevisite');
    }
}
