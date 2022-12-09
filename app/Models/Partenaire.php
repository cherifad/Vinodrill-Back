<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partenaire
 * 
 * @property int $idpartenaire
 * @property string $nompartenaire
 * @property string|null $ruepartenaire
 * @property string|null $cppartenaire
 * @property string|null $villepartenaire
 * @property string|null $photopartenaire
 * @property string|null $emailpartenaire
 * @property string|null $contact
 * @property string|null $detailpartenaire
 * 
 * @property Societe $societe
 * @property Collection|Avispartenaire[] $avispartenaires
 * @property Collection|AImage[] $a_images
 * @property Cave $cave
 * @property Hotel $hotel
 * @property Restaurant $restaurant
 *
 * @package App\Models
 */
class Partenaire extends Model
{
	protected $table = 'partenaire';
	public $incrementing = false;
	public $timestamps = false;
    protected $primaryKey = 'idpartenaire';

	protected $casts = [
		'idpartenaire' => 'int'
	];

	protected $fillable = [
		'nompartenaire',
		'ruepartenaire',
		'cppartenaire',
		'villepartenaire',
		'photopartenaire',
		'emailpartenaire',
		'contact',
		'detailpartenaire'
	];

	public function societe()
	{
		return $this->hasOne(Societe::class, 'idpartenaire');
	}

	public function avispartenaires()
	{
		return $this->hasMany(Avispartenaire::class, 'idpartenaire');
	}

	public function a_images()
	{
		return $this->hasMany(AImage::class, 'idpartenaire');
	}

	public function cave()
	{
		return $this->hasOne(Cave::class, 'idpartenaire');
	}

	public function hotel()
	{
		return $this->hasOne(Hotel::class, 'idpartenaire');
	}

	public function restaurant()
	{
		return $this->hasOne(Restaurant::class, 'idpartenaire');
	}
}
