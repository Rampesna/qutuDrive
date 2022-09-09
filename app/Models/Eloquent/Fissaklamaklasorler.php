<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Fissaklamaklasorler
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $KAYNAKBILGISAYARADI
 * @property int|null $CONSTRTURU
 * @property string|null $MSSQLCONSTR
 * @property string|null $ACCESSDOSYAYOLU
 * @property string|null $ACCESSPAROLA
 * @property string|null $ODBCADI
 * @property string|null $ODBCKULLANICIADI
 * @property string|null $ODBCPAROLA
 * @property string|null $EXCELDOSYAYOLU
 * @property string|null $SORGU
 * @property string|null $ONAYLAYANADSOYAD
 * @property string|null $MALIMUHURSERINO
 * @property string|null $MALIMUHURPIN
 * @property string|null $ZAMANDAMGASILINK
 * @property string|null $ZAMANDAMGASIKULLANICIADI
 * @property string|null $ZAMANDAMGASIPAROLA
 * @property int|null $AKTIF
 *
 * @package App\Models
 */
class Fissaklamaklasorler extends Model
{
    use SoftDeletes;

	protected $table = 'fissaklamaklasorler';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'CONSTRTURU' => 'int',
		'AKTIF' => 'int'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'KAYNAKBILGISAYARADI',
		'CONSTRTURU',
		'MSSQLCONSTR',
		'ACCESSDOSYAYOLU',
		'ACCESSPAROLA',
		'ODBCADI',
		'ODBCKULLANICIADI',
		'ODBCPAROLA',
		'EXCELDOSYAYOLU',
		'SORGU',
		'ONAYLAYANADSOYAD',
		'MALIMUHURSERINO',
		'MALIMUHURPIN',
		'ZAMANDAMGASILINK',
		'ZAMANDAMGASIKULLANICIADI',
		'ZAMANDAMGASIPAROLA',
		'AKTIF'
	];
}
