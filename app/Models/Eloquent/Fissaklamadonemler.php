<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Fissaklamadonemler
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $SUNUCUKLASORLERID
 * @property int|null $YIL
 * @property int|null $AY
 * @property int|null $GUN
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Fissaklamadonemler extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'fissaklamadonemler';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'YIL' => 'int',
		'AY' => 'int',
		'GUN' => 'int',
		'DURUM' => 'int'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'SUNUCUKLASORLERID',
		'YIL',
		'AY',
		'GUN',
		'DURUM'
	];
}
