<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Etape
 * 
 * @property int $idetape
 * @property int $idsejour
 * @property int|null $idhebergement
 * @property string $titreetape
 * @property string|null $descriptionetape
 * @property string|null $photoetape
 * @property string|null $urletape
 * @property string|null $videoetape
 * 
 * @property Sejour $sejour
 * @property Hebergement|null $hebergement
 * @property Collection|AOption[] $a_options
 * @property Collection|Effectue[] $effectues
 * @property Collection|EstCompose[] $est_composes
 * @property Collection|FaitPartiDe[] $fait_parti_des
 *
 * @package App\Models
 */
class Etape extends Model
{
	protected $table = 'etape';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idetape' => 'int',
		'idsejour' => 'int',
		'idhebergement' => 'int'
	];

	protected $fillable = [
		'idsejour',
		'idhebergement',
		'titreetape',
		'descriptionetape',
		'photoetape',
		'urletape',
		'videoetape'
	];

	public function sejour()
	{
		return $this->belongsTo(Sejour::class, 'idsejour')
					->where('sejour.idsejour', '=', 'etape.idsejour')
					->where('sejour.idsejour', '=', 'etape.idsejour');
	}

	public function hebergement()
	{
		return $this->belongsTo(Hebergement::class, 'idhebergement');
	}

	public function a_options()
	{
		return $this->hasMany(AOption::class, 'idetape');
	}

	public function effectues()
	{
		return $this->hasMany(Effectue::class, 'idetape');
	}

	public function est_composes()
	{
		return $this->hasMany(EstCompose::class, 'idetape');
	}

	public function fait_parti_des()
	{
		return $this->hasMany(FaitPartiDe::class, 'idetape');
	}
}
