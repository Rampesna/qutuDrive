<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sozlesmeler
 *
 * @property int $ID
 * @property int|null $FIRMAID
 * @property string|null $VKNTCKN
 * @property string|null $SOZLESMEHTML
 * @property string|null $SOZLESMENO
 * @property string|null $SOZLESMEID
 * @property int|null $DURUM
 * @property Carbon|null $KAYITTARIHI
 * @property Carbon|null $GUNCELLEMETARIHI
 * @property int|null $KULLANICIID
 * @property int|null $YAZICI
 * @property int|null $PDF
 * @property int|null $MANUEL
 * @property string|null $EKBELGELER
 *
 * @package App\Models
 */
class Sozlesmeler extends BaseModel
{
    use SoftDeletes;

	protected $table = 'sozlesmeler';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'FIRMAID' => 'int',
		'DURUM' => 'int',
		'KULLANICIID' => 'int',
		'YAZICI' => 'int',
		'PDF' => 'int',
		'MANUEL' => 'int'
	];

	protected $dates = [
		'KAYITTARIHI',
		'GUNCELLEMETARIHI'
	];

	protected $fillable = [
		'FIRMAID',
		'VKNTCKN',
		'SOZLESMEHTML',
		'SOZLESMENO',
		'SOZLESMEID',
		'DURUM',
		'KAYITTARIHI',
		'GUNCELLEMETARIHI',
		'KULLANICIID',
		'YAZICI',
		'PDF',
		'MANUEL',
		'EKBELGELER'
	];
}
