<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Syncdosyahareket
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $SUNUCUKLASORLERID
 * @property string|null $DOSYAADI
 * @property string|null $DOSYAUZANTISI
 * @property string|null $YERELDOSYAYOLU
 * @property Carbon|null $KAYITTARIHI
 * @property int|null $DURUM
 * @property float|null $DOSYABOYUTU
 * @property Carbon|null $SILINMETARIHI
 * @property Carbon|null $DOSYADEGISTIRILMETARIHI
 * @property float|null $ZIPDOSYABOYUTU
 *
 * @package App\Models
 */
class Syncdosyahareket extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'syncdosyahareket';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int',
		'DOSYABOYUTU' => 'float',
		'ZIPDOSYABOYUTU' => 'float'
	];

	protected $dates = [
		'KAYITTARIHI',
		'SILINMETARIHI',
		'DOSYADEGISTIRILMETARIHI'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'SUNUCUKLASORLERID',
		'DOSYAADI',
		'DOSYAUZANTISI',
		'YERELDOSYAYOLU',
		'KAYITTARIHI',
		'DURUM',
		'DOSYABOYUTU',
		'SILINMETARIHI',
		'DOSYADEGISTIRILMETARIHI',
		'ZIPDOSYABOYUTU'
	];
}
