<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idpartenaire
 * @property integer $nbetoilehotel
 * @property string $nompartenaire
 * @property string $ruepartenaire
 * @property string $cppartenaire
 * @property string $villepartenaire
 * @property string $photopartenaire
 * @property string $emailpartenaire
 * @property string $contact
 * @property string $detailpartenaire
 * @property Etoilehotel $etoilehotel
 * @property Partenaire $partenaire
 * @property Hebergement[] $hebergements
 */
class Hotel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hotel';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idpartenaire';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nbetoilehotel', 'nompartenaire', 'ruepartenaire', 'cppartenaire', 'villepartenaire', 'photopartenaire', 'emailpartenaire', 'contact', 'detailpartenaire'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function etoilehotel()
    {
        return $this->belongsTo('App\Models\Etoilehotel', 'nbetoilehotel', 'nbetoilehotel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partenaire()
    {
        return $this->belongsTo('App\Models\Partenaire', 'idpartenaire', 'idpartenaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hebergements()
    {
        return $this->hasMany('App\Models\Hebergement', 'idpartenaire', 'idpartenaire');
    }
}
