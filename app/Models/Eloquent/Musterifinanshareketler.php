<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Musterifinanshareketler
 *
 * @property int $ID
 * @property int|null $MUSTERIID
 * @property Carbon|null $TARIH
 * @property int|null $FISTURU
 * @property string|null $ACIKLAMA
 * @property string|null $BELGENO
 * @property float|null $TUTAR
 * @property int|null $BA
 *
 * @package App\Models
 */
class Musterifinanshareketler extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'musterifinanshareketler';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'MUSTERIID' => 'int',
		'FISTURU' => 'int',
		'TUTAR' => 'float',
		'BA' => 'int'
	];

	protected $dates = [
		'TARIH'
	];

	protected $fillable = [
		'MUSTERIID',
		'TARIH',
		'FISTURU',
		'ACIKLAMA',
		'BELGENO',
		'TUTAR',
		'BA'
	];
}
