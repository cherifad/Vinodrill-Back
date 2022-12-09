<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Catparticipant
 * 
 * @property int $idcategorieparticipant
 * @property string|null $nomcategorieparticipant
 * 
 * @property Collection|Participe[] $participes
 *
 * @package App\Models
 */
class Catparticipant extends Model
{
	protected $table = 'catparticipant';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idcategorieparticipant' => 'int'
	];

	protected $fillable = [
		'nomcategorieparticipant'
	];

	public function participes()
	{
		return $this->hasMany(Participe::class, 'idcategorieparticipant');
	}
}
