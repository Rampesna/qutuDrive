<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Musteriler
 *
 * @property int $ID
 * @property string|null $APIKEY
 * @property string|null $FIRMAUNVAN
 * @property int|null $DURUM
 * @property string|null $BAYIKODU
 * @property string|null $YETKILI
 * @property string|null $VKNTCKN
 * @property string|null $VERGIDAIRESI
 * @property string|null $ADRES
 *
 * @package App\Models
 */
class Musteriler extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'musteriler';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int'
	];

	protected $fillable = [
		'APIKEY',
		'FIRMAUNVAN',
		'DURUM',
		'BAYIKODU',
		'YETKILI',
		'VKNTCKN',
		'VERGIDAIRESI',
		'ADRES'
	];
}
