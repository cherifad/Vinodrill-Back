<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sejour
 * 
 * @property int $idsejour
 * @property int $iddestination
 * @property int $idtheme
 * @property string $titresejour
 * @property string|null $photosejour
 * @property float $prixsejour
 * @property string|null $descriptionsejour
 * @property int|null $nbjour
 * @property int|null $nbnuit
 * @property string|null $libelletemps
 * @property float|null $notemoyenne
 * 
 * @property Destination $destination
 * @property Theme $theme
 * @property Collection|Avi[] $avis
 * @property Collection|Etape[] $etapes
 * @property Collection|Favori[] $favoris
 * @property Collection|Participe[] $participes
 * @property Collection|Reservation[] $reservations
 *
 * @package App\Models
 */
class Sejour extends Model
{
	protected $table = 'sejour';
	public $incrementing = false;
	public $timestamps = false;
	protected $primaryKey = 'idsejour';

	protected $casts = [
		'idsejour' => 'int',
		'iddestination' => 'int',
		'idtheme' => 'int',
		'prixsejour' => 'float',
		'nbjour' => 'int',
		'nbnuit' => 'int',
		'notemoyenne' => 'float'
	];

	protected $fillable = [
		'iddestination',
		'idtheme',
		'titresejour',
		'photosejour',
		'prixsejour',
		'descriptionsejour',
		'nbjour',
		'nbnuit',
		'libelletemps',
		'notemoyenne'
	];

	public function scopeTitle($query, $title)
	{
		return $query->where('titresejour', 'like', '%' . $title . '%');
	}

	public function destination()
	{
		return $this->belongsTo(Destination::class, 'iddestination');
	}

	public function theme()
	{
		return $this->belongsTo(Theme::class, 'idtheme');
	}

	public function avis()
	{
		return $this->hasMany(Avi::class, 'idsejour');
	}

	public function etapes()
	{
		return $this->hasMany(Etape::class, 'idsejour');
	}

	// join multiple tables
	public function scopeJoinTables($query)
	{
		return $query->join('destination', 'sejour.iddestination', '=', 'destination.iddestination')
			->join('theme', 'sejour.idtheme', '=', 'theme.idtheme');
	}

	public function favoris()
	{
		return $this->hasMany(Favori::class, 'idsejour');
	}

	public function catparticipant()
	{
		return $this->hasMany(Participe::class, 'idsejour');
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class, 'idsejour');
	}
}
