<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idpartenaire
 * @property integer $idtypeactivite
 * @property string $nompartenaire
 * @property string $ruepartenaire
 * @property string $cppartenaire
 * @property string $villepartenaire
 * @property string $photopartenaire
 * @property string $emailpartenaire
 * @property string $contact
 * @property string $detailpartenaire
 * @property Partenaire $partenaire
 * @property Typeactivite $typeactivite
 * @property Activite[] $activites
 */
class Societe extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'societe';

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
    protected $fillable = ['idtypeactivite', 'nompartenaire', 'ruepartenaire', 'cppartenaire', 'villepartenaire', 'photopartenaire', 'emailpartenaire', 'contact', 'detailpartenaire'];

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
    public function typeactivite()
    {
        return $this->belongsTo('App\Models\Typeactivite', 'idtypeactivite', 'idtypeactivite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activites()
    {
        return $this->hasMany('App\Models\Activite', 'idpartenaire', 'idpartenaire');
    }
}
