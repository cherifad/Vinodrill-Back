<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $idclient
 * @property integer $idavis
 * @property integer $idcb
 * @property string $nomclient
 * @property string $prenomclient
 * @property string $datenaissance
 * @property string $sexe
 * @property string $motdepasse
 * @property string $emailclient
 * @property Paiement[] $paiements
 * @property Commande[] $commandes
 * @property Avispartenaire[] $avispartenaires
 * @property Adopte[] $adoptes
 * @property Avi[] $avis
 * @property Adresse[] $adresses
 * @property Favori[] $favoris
 * @property Cb $cb
 * @property Avi $avi
 */
class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'client';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'idclient';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['idavis', 'idcb', 'nomclient', 'prenomclient', 'datenaissance', 'sexe', 'motdepasse', 'emailclient'];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'motdepasse',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paiements()
    {
        return $this->hasMany('App\Models\Paiement', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commandes()
    {
        return $this->hasMany('App\Models\Commande', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function avispartenaires()
    {
        return $this->hasMany('App\Models\Avispartenaire', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adoptes()
    {
        return $this->hasMany('App\Models\Adopte', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function avis()
    {
        return $this->hasMany('App\Models\Avi', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adresses()
    {
        return $this->hasMany('App\Models\Adresse', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoris()
    {
        return $this->hasMany('App\Models\Favori', 'idclient', 'idclient');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cb()
    {
        return $this->belongsTo('App\Models\Cb', 'idcb', 'idcb');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avi()
    {
        return $this->belongsTo('App\Models\Avi', 'idavis', 'idavis');
    }
}
