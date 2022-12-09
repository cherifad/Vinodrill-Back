<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idpaiement
 * @property integer $idclient
 * @property string $libellepaiement
 * @property boolean $preference
 * @property Commande[] $commandes
 * @property Client $client
 */
class Paiement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'paiement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idpaiement';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idclient', 'libellepaiement', 'preference'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commandes()
    {
        return $this->hasMany('App\Models\Commande', 'idpaiement', 'idpaiement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'idclient', 'idclient');
    }
}
