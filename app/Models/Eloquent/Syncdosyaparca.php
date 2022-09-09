<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Syncdosyaparca
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $SYNCDOSYAHAREKETID
 * @property string|null $DOSYAADI
 * @property Carbon|null $KAYITTARIHI
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Syncdosyaparca extends Model
{
    use SoftDeletes;

	protected $table = 'syncdosyaparca';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int'
	];

	protected $dates = [
		'KAYITTARIHI'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'SYNCDOSYAHAREKETID',
		'DOSYAADI',
		'KAYITTARIHI',
		'DURUM'
	];
}
