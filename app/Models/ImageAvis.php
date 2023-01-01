<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idimage
 * @property integer $idavis
 * @property Avi $avi
 * @property Image $image
 */
class ImageAvis extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'image_avi';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avi()
    {
        return $this->belongsTo('App\Models\Avi', 'idavis', 'idavis');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'idimage', 'idimage');
    }
}
