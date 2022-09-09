<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Musterileralt
 *
 * @property int $ID
 * @property int|null $MUSTERIID
 * @property string|null $KULLANICIADI
 * @property string|null $KULLANICISIFRE
 * @property string|null $APIKEY
 * @property string|null $AD
 * @property string|null $SOYAD
 * @property string|null $TELEFON
 * @property string|null $FIRMAUNVAN
 * @property int|null $DURUM
 * @property int|null $KULLANICITIPI
 * @property Carbon|null $KAYITTARIHI
 *
 * @package App\Models
 */
class Musterileralt extends Model
{
    use SoftDeletes;

	protected $table = 'musterileralt';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'MUSTERIID' => 'int',
		'DURUM' => 'int',
		'KULLANICITIPI' => 'int'
	];

	protected $dates = [
		'KAYITTARIHI'
	];

	protected $fillable = [
		'MUSTERIID',
		'KULLANICIADI',
		'KULLANICISIFRE',
		'APIKEY',
		'AD',
		'SOYAD',
		'TELEFON',
		'FIRMAUNVAN',
		'DURUM',
		'KULLANICITIPI',
		'KAYITTARIHI'
	];
}
