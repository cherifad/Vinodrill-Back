<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idhebergement
 * @property integer $idpartenaire
 * @property string $libellehebergement
 * @property string $descriptionhebergement
 * @property integer $nbchambre
 * @property string $horairehebergement
 * @property Etape[] $etapes
 * @property Hotel $hotel
 */
class Hebergement extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'hebergement';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idhebergement';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idpartenaire', 'libellehebergement', 'descriptionhebergement', 'nbchambre', 'horairehebergement'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function etapes()
    {
        return $this->hasMany(Etape::class, 'idhebergement', 'idhebergement');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'idpartenaire', 'idpartenaire');
    }
}
