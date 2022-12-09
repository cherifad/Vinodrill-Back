<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Destination
 * 
 * @property int $iddestination
 * @property string $libelledestination
 * @property string|null $descriptiondestination
 * 
 * @property Collection|Sejour[] $sejours
 *
 * @package App\Models
 */
class Destination extends Model
{
	protected $table = 'destination';
	public $incrementing = false;
	public $timestamps = false;

	protected $primaryKey = 'iddestination';

	protected $casts = [
		'iddestination' => 'int'
	];

	protected $fillable = [
		'libelledestination',
		'descriptiondestination'
	];

	public function sejours()
	{
		return $this->hasMany(Sejour::class, 'iddestination');
	}
}
