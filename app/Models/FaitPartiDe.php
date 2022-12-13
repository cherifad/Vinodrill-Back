<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idvisite
 * @property integer $idetape
 * @property Etape $etape
 * @property Visite $visite
 */
class FaitPartiDe extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fait_parti_de';

    protected $primaryKey = ['idvisite', 'idetape'];

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function etape()
    {
        return $this->belongsTo('App\Models\Etape', 'idetape', 'idetape');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visite()
    {
        return $this->belongsTo('App\Models\Visite', 'idvisite', 'idvisite');
    }
}
