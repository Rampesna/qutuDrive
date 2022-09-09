<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Firmalar
 *
 * @property int $ID
 * @property string|null $APIKEY
 * @property string|null $FIRMAUNVAN
 * @property string|null $VKNTCKN
 * @property string|null $AD
 * @property string|null $SOYAD
 * @property string|null $VERGIDAIRESI
 * @property string|null $ADRES
 * @property string|null $TELEFON
 * @property string|null $MAIL
 * @property string|null $BAYIKODU
 * @property int|null $DURUM
 * @property int|null $EDEFTERKAYNAKTURU
 * @property Carbon|null $KAYITTARIHI
 * @property string|null $BASLANGICYILI
 * @property string|null $ISLEMDURUMU
 *
 * @package App\Models
 */
class Firmalar extends Model
{
    use SoftDeletes;

	protected $table = 'firmalar';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int',
		'EDEFTERKAYNAKTURU' => 'int'
	];

	protected $dates = [
		'KAYITTARIHI'
	];

	protected $fillable = [
		'APIKEY',
		'FIRMAUNVAN',
		'VKNTCKN',
		'AD',
		'SOYAD',
		'VERGIDAIRESI',
		'ADRES',
		'TELEFON',
		'MAIL',
		'BAYIKODU',
		'DURUM',
		'EDEFTERKAYNAKTURU',
		'KAYITTARIHI',
		'BASLANGICYILI',
		'ISLEMDURUMU'
	];
}
