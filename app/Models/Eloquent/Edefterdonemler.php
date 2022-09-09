<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Edefterdonemler
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $SUNUCUKLASORLERID
 * @property int|null $YIL
 * @property int|null $AY
 * @property int|null $DEFTERTURKODU
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Edefterdonemler extends Model
{
    use SoftDeletes;

	protected $table = 'edefterdonemler';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'YIL' => 'int',
		'AY' => 'int',
		'DEFTERTURKODU' => 'int',
		'DURUM' => 'int'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'SUNUCUKLASORLERID',
		'YIL',
		'AY',
		'DEFTERTURKODU',
		'DURUM'
	];
}
