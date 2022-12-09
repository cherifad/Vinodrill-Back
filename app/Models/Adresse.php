<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idadresse
 * @property integer $idclient
 * @property string $libelleadresse
 * @property string $rueadresse
 * @property string $villeadresse
 * @property string $cpadresse
 * @property string $pays
 * @property Client $client
 */
class Adresse extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'adresse';

    // set updated_at and created_at to false
    public $timestamps = false;

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idadresse';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idclient', 'libelleadresse', 'rueadresse', 'villeadresse', 'cpadresse', 'pays'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'idclient', 'idclient');
    }
}
