<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Edefterdosyalar
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
 * @property int|null $GIBDURUM
 * @property Carbon|null $GIBGONDERIMTARIHI
 * @property string|null $GIBKUYRUKDURUM
 * @property Carbon|null $GIBKUYRUKTARIHI
 * @property string|null $DOSYAIMZA
 * @property int|null $SERVISDURUMU
 *
 * @package App\Models
 */
class Edefterdosyalar extends Model
{
    use SoftDeletes;

	protected $table = 'edefterdosyalar';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'DOSYABOYUTU' => 'float',
		'DURUM' => 'int',
		'ZIPDOSYABOYUTU' => 'float',
		'GIBDURUM' => 'int',
		'SERVISDURUMU' => 'int'
	];

	protected $dates = [
		'KAYITTARIHI',
		'GIBGONDERIMTARIHI',
		'GIBKUYRUKTARIHI'
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
		'ZIPDOSYABOYUTU',
		'GIBDURUM',
		'GIBGONDERIMTARIHI',
		'GIBKUYRUKDURUM',
		'GIBKUYRUKTARIHI',
		'DOSYAIMZA',
		'SERVISDURUMU'
	];
}
