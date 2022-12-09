<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idvisite
 * @property integer $idtypevisite
 * @property integer $idpartenaire
 * @property string $libellevisite
 * @property string $descriptionvisite
 * @property string $horairevisite
 * @property Typevisite $typevisite
 * @property Cave $cave
 * @property Etape[] $etapes
 */
class Visite extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'visite';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idvisite';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idtypevisite', 'idpartenaire', 'libellevisite', 'descriptionvisite', 'horairevisite'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typevisite()
    {
        return $this->belongsTo('App\Models\Typevisite', 'idtypevisite', 'idtypevisite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cave()
    {
        return $this->belongsTo('App\Models\Cave', 'idpartenaire', 'idpartenaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function etapes()
    {
        return $this->belongsToMany('App\Models\Etape', 'fait_parti_de', 'idvisite', 'idetape');
    }
}
