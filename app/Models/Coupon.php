<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commande;

/**
 * @property integer $idbonreduction
 * @property integer $refcommande
 * @property string $codebonreduction
 * @property string $datevalidite
 * @property boolean $estvalide
 */
class Coupon extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bonreduction';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idbonreduction';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['refcommande', 'codebonreduction', 'datevalidite', 'estvalide'];

    public function montant($refcommande)
    {
        $coupon_amount = Commande::find($refcommande)->prixcommande;
        return $coupon_amount;
    }
}
