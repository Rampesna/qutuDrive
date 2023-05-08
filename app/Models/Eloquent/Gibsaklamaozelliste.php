<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gibsaklamaozelliste
 *
 * @property int $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $VKNTCKN
 * @property string|null $UNVAN
 * @property int|null $DURUM
 * @property Carbon|null $TARIH
 * @property int|null $VIP
 *
 * @package App\Models
 */
class Gibsaklamaozelliste extends BaseModel
{
    use SoftDeletes;

	protected $table = 'gibsaklamaozelliste';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int',
		'VIP' => 'int'
	];

	protected $dates = [
		'TARIH'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'VKNTCKN',
		'UNVAN',
		'DURUM',
		'TARIH',
		'VIP'
	];
}
