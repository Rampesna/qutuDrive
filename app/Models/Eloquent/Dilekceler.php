<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Dilekceler
 *
 * @property int $ID
 * @property int|null $TUR
 * @property string|null $DEGER
 * @property string|null $ACIKLAMA
 * @property string|null $ISLEMIYAPANKULLANICI
 * @property string|null $DILEKCEYOLU
 * @property Carbon|null $TARIH
 * @property string|null $GUID
 *
 * @package App\Models
 */
class Dilekceler extends Model
{
    use SoftDeletes;

	protected $table = 'dilekceler';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'TUR' => 'int'
	];

	protected $dates = [
		'TARIH'
	];

	protected $fillable = [
		'TUR',
		'DEGER',
		'ACIKLAMA',
		'ISLEMIYAPANKULLANICI',
		'DILEKCEYOLU',
		'TARIH',
		'GUID'
	];
}
