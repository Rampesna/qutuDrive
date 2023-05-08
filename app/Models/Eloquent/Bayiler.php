<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bayiler
 *
 * @property int $ID
 * @property string|null $BAYIKODU
 * @property string|null $BAYIUNVAN
 * @property string|null $BAYITELEFON
 * @property string|null $BAYIADRES
 * @property float|null $BAYIORAN
 * @property string|null $USTBAYIKODU
 * @property int|null $DURUM
 * @property string|null $BAYIVKN
 *
 * @package App\Models
 */
class Bayiler extends BaseModel
{
    use SoftDeletes;

	protected $table = 'bayiler';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'BAYIORAN' => 'float',
		'DURUM' => 'int'
	];

	protected $fillable = [
		'BAYIKODU',
		'BAYIUNVAN',
		'BAYITELEFON',
		'BAYIADRES',
		'BAYIORAN',
		'USTBAYIKODU',
		'DURUM',
		'BAYIVKN'
	];
}
