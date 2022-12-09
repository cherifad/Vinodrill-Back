<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Theme
 * 
 * @property int $idtheme
 * @property string $libelletheme
 * 
 * @property Collection|Sejour[] $sejours
 *
 * @package App\Models
 */
class Theme extends Model
{
	protected $table = 'theme';
	public $incrementing = false;
	public $timestamps = false;
	protected $primaryKey = 'idtheme';

	protected $casts = [
		'idtheme' => 'int'
	];

	protected $fillable = [
		'libelletheme'
	];

	public function sejours()
	{
		return $this->hasMany(Sejour::class, 'idtheme');
	}
}
