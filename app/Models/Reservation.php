<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $refcommande
 * @property integer $idsejour
 * @property string $datedebutreservation
 * @property boolean $estcadeau
 * @property integer $nbenfant
 * @property integer $nbadulte
 * @property integer $nbchambre
 * @property Commande $commande
 * @property Sejour $sejour
 */
class Reservation extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'reservation';

    public $timestamps = false;

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'refcommande';

    /**
     * @var array
     */
    protected $fillable = ['datedebutreservation', 'estcadeau', 'nbenfant', 'nbadulte', 'nbchambre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commande()
    {
        return $this->belongsTo('App\Models\Commande', 'refcommande', 'refcommande');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sejour()
    {
        return $this->belongsTo('App\Models\Sejour', 'idsejour', 'idsejour');
    }
}
