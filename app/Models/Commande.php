<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $refcommande
 * @property integer $idclient
 * @property integer $idpaiement
 * @property string $datecommande
 * @property float $prixcommande
 * @property integer $quantite
 * @property string $message
 * @property string $cheminfacture
 * @property Client $client
 * @property Paiement $paiement
 * @property Reservation[] $reservations
 * @property Boncommande[] $boncommandes
 */
class Commande extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'commande';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'refcommande';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idclient', 'idpaiement', 'datecommande', 'prixcommande', 'quantite', 'message', 'cheminfacture'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paiement()
    {
        return $this->belongsTo('App\Models\Paiement', 'idpaiement', 'idpaiement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation', 'refcommande', 'refcommande');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boncommandes()
    {
        return $this->hasMany('App\Models\Boncommande', 'refcommande', 'refcommande');
    }
}
