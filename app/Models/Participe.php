<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Participe
 * 
 * @property int $idcategorieparticipant
 * @property int $idsejour
 * 
 * @property Catparticipant $catparticipant
 * @property Sejour $sejour
 *
 * @package App\Models
 */
class Participe extends Model
{
	protected $table = 'participe';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'idcategorieparticipant' => 'int',
		'idsejour' => 'int'
	];

	public function catparticipant()
	{
		return $this->belongsTo(Catparticipant::class, 'idcategorieparticipant')
					->where('catparticipant.idcategorieparticipant', '=', 'participe.idcategorieparticipant')
					->where('catparticipant.idcategorieparticipant', '=', 'participe.idcategorieparticipant');
	}

	public function sejour()
	{
		return $this->belongsTo(Sejour::class, 'idsejour')
					->where('sejour.idsejour', '=', 'participe.idsejour')
					->where('sejour.idsejour', '=', 'participe.idsejour');
	}
}
