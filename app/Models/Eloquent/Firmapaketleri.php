<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Firmapaketleri
 *
 * @property int $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $PAKETKODU
 * @property string|null $PAKETADI
 * @property float|null $PAKETBOYUTU
 * @property float|null $PAKETFIYATI
 * @property Carbon|null $BASLANGICTARIHI
 * @property Carbon|null $BITISTARIHI
 * @property int|null $DURUM
 * @property string|null $ODEMESEKLI
 *
 * @package App\Models
 */
class Firmapaketleri extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'firmapaketleri';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'PAKETBOYUTU' => 'float',
		'PAKETFIYATI' => 'float',
		'DURUM' => 'int'
	];

	protected $dates = [
		'BASLANGICTARIHI',
		'BITISTARIHI'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'PAKETKODU',
		'PAKETADI',
		'PAKETBOYUTU',
		'PAKETFIYATI',
		'BASLANGICTARIHI',
		'BITISTARIHI',
		'DURUM',
		'ODEMESEKLI'
	];
}
