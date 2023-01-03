<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $rep_idavis
 * @property integer $idavis
 * @property Avi $avi
 * @property Avi $avi
 */
class ReponseAvi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'a_repondu';

    /**
     * @var array
     */
    protected $fillable = ['rep_idavis', 'idavis'];

    public $timestamps = false;

    // set primary key to rep_idavis and idavis
    protected $primaryKey = 'rep_idavis';

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
    public function rep_avi()
    {
        return $this->belongsTo('App\Models\Avi', 'rep_idavis', 'idavis');
    }
}
