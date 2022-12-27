<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idactivite
 * @property integer $idpartenaire
 * @property string $libelleactivite
 * @property string $descriptionactivite
 * @property string $ruerdv
 * @property string $cprdv
 * @property string $villerdv
 * @property string $horaireactivite
 * @property Etape[] $etapes
 * @property Societe $societe
 */
class Activite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'activite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idactivite';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['idpartenaire', 'libelleactivite', 'descriptionactivite', 'ruerdv', 'cprdv', 'villerdv', 'horaireactivite'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function etapes()
    {
        return $this->belongsToMany('App\Models\Etape', 'effectue', 'idactivite', 'idetape');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function societe()
    {
        return $this->belongsTo('App\Models\Societe', 'idpartenaire', 'idpartenaire');
    }
}
