<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Edefterklasorler
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $KAYNAKBILGISAYARADI
 * @property string|null $KAYNAKKLASORYOLU
 * @property int|null $AKTIF
 * @property int|null $WEBSERVISDENINDIR
 * @property string|null $WEBSERVISKULLANICIADI
 * @property string|null $WEBSERVISKULLANICIPAROLA
 * @property int|null $GIBIKINCILSAKLAMA
 * @property int|null $YEDEKBASLANGICYILI
 * @property int|null $NASKULLAN
 * @property string|null $NASDOMAIN
 * @property string|null $NASKULLANICIADI
 * @property string|null $NASKULLANICIPAROLA
 *
 * @package App\Models
 */
class Edefterklasorler extends Model
{
    use SoftDeletes;

	protected $table = 'edefterklasorler';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'AKTIF' => 'int',
		'WEBSERVISDENINDIR' => 'int',
		'GIBIKINCILSAKLAMA' => 'int',
		'YEDEKBASLANGICYILI' => 'int',
		'NASKULLAN' => 'int'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'KAYNAKBILGISAYARADI',
		'KAYNAKKLASORYOLU',
		'AKTIF',
		'WEBSERVISDENINDIR',
		'WEBSERVISKULLANICIADI',
		'WEBSERVISKULLANICIPAROLA',
		'GIBIKINCILSAKLAMA',
		'YEDEKBASLANGICYILI',
		'NASKULLAN',
		'NASDOMAIN',
		'NASKULLANICIADI',
		'NASKULLANICIPAROLA'
	];
}
