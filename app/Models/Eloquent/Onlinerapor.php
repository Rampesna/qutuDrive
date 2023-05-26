<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Onlinerapor
 *
 * @property string $ID
 * @property string|null $KULLANICIAPIKEY
 * @property Carbon|null $SUNUCUTARIH
 * @property int|null $SUNUCUSAAT
 * @property Carbon|null $LOCALTARIH
 * @property int|null $LOCALSAAT
 * @property string|null $LOCALIP
 * @property string|null $DISIP
 * @property string|null $BILGISAYARADI
 * @property string|null $WINDOWSKULLANICIADI
 * @property int|null $UYGULAMATURU
 * @property int|null $UYGULAMAVERSIYON
 * @property int|null $DBVERSIYON
 *
 * @package App\Models
 */
class Onlinerapor extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'onlinerapor';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'SUNUCUSAAT' => 'int',
		'LOCALSAAT' => 'int',
		'UYGULAMATURU' => 'int',
		'UYGULAMAVERSIYON' => 'int',
		'DBVERSIYON' => 'int'
	];

	protected $dates = [
		'SUNUCUTARIH',
		'LOCALTARIH'
	];

	protected $fillable = [
		'KULLANICIAPIKEY',
		'SUNUCUTARIH',
		'SUNUCUSAAT',
		'LOCALTARIH',
		'LOCALSAAT',
		'LOCALIP',
		'DISIP',
		'BILGISAYARADI',
		'WINDOWSKULLANICIADI',
		'UYGULAMATURU',
		'UYGULAMAVERSIYON',
		'DBVERSIYON'
	];
}
