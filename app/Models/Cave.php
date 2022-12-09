<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idpartenaire
 * @property integer $idtypedegustation
 * @property string $nompartenaire
 * @property string $ruepartenaire
 * @property string $cppartenaire
 * @property string $villepartenaire
 * @property string $photopartenaire
 * @property string $emailpartenaire
 * @property string $contact
 * @property string $detailpartenaire
 * @property Visite[] $visites
 * @property Partenaire $partenaire
 * @property Typedegustation $typedegustation
 */
class Cave extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cave';

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
    protected $fillable = ['idtypedegustation', 'nompartenaire', 'ruepartenaire', 'cppartenaire', 'villepartenaire', 'photopartenaire', 'emailpartenaire', 'contact', 'detailpartenaire'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visites()
    {
        return $this->hasMany('App\Models\Visite', 'idpartenaire', 'idpartenaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partenaire()
    {
        return $this->belongsTo('App\Models\Partenaire', 'idpartenaire', 'idpartenaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typedegustation()
    {
        return $this->belongsTo('App\Models\Typedegustation', 'idtypedegustation', 'idtypedegustation');
    }
}
