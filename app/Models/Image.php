<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idimage
 * @property string $lienimage
 * @property Partenaire[] $partenaires
 * @property Avi[] $avis
 */
class Image extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'image';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idimage';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['lienimage'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function partenaires()
    {
        return $this->belongsToMany('App\Models\Partenaire', 'a_image', 'idimage', 'idpartenaire');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function avis()
    {
        return $this->belongsToMany('App\Models\Avi', 'image_avi', 'idimage', 'idavis');
    }
}
