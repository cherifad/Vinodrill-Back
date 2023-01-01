<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $idboncommande
 * @property integer $refcommande
 * @property string $codeboncommande
 * @property string $datevalidite
 * @property boolean $estvalide
 * @property Commande $commande
 */
class Boncommande extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'boncommande';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idboncommande';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['refcommande', 'codeboncommande', 'datevalidite', 'estvalide'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commande()
    {
        return $this->belongsTo('App\Models\Commande', 'refcommande', 'refcommande');
    }
}
