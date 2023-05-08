<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Fissaklamadosyalar
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $DONEMLERID
 * @property string|null $DOSYAADI
 * @property string|null $DOSYAUZANTISI
 * @property string|null $SUNUCUDOSYAADI
 * @property float|null $DOSYABOYUTU
 * @property string|null $YERELDOSYAYOLU
 * @property Carbon|null $KAYITTARIHI
 * @property int|null $DURUM
 * @property float|null $ZIPDOSYABOYUTU
 *
 * @package App\Models
 */
class Fissaklamadosyalar extends BaseModel
{
    use SoftDeletes;

	protected $table = 'fissaklamadosyalar';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'DOSYABOYUTU' => 'float',
		'DURUM' => 'int',
		'ZIPDOSYABOYUTU' => 'float'
	];

	protected $dates = [
		'KAYITTARIHI'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'DONEMLERID',
		'DOSYAADI',
		'DOSYAUZANTISI',
		'SUNUCUDOSYAADI',
		'DOSYABOYUTU',
		'YERELDOSYAYOLU',
		'KAYITTARIHI',
		'DURUM',
		'ZIPDOSYABOYUTU'
	];
}
