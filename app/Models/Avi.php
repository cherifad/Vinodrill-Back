<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idavis
 * @property integer $idclient
 * @property integer $idsejour
 * @property integer $note
 * @property string $commentaire
 * @property string $titreavis
 * @property string $dateavis
 * @property boolean $avisignale
 * @property string $typesignalement
 * @property Client[] $clients
 * @property Image[] $images
 * @property Sejour $sejour
 * @property Client $client
 */
class Avi extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idavis';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idclient', 'idsejour', 'note', 'commentaire', 'titreavis', 'dateavis', 'avisignale', 'typesignalement'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany('App\Models\Client', 'idavis', 'idavis');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany('App\Models\Image', 'image_avi', 'idavis', 'idimage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sejour()
    {
        return $this->belongsTo('App\Models\Sejour', 'idsejour', 'idsejour');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'idclient', 'idclient');
    }
}
