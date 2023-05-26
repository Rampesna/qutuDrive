<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bankabilgileri
 *
 * @property int $ID
 * @property string|null $BAYIKODU
 * @property string|null $HESAPSAHIBI
 * @property string|null $BANKAADI
 * @property string|null $IBAN
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Bankabilgileri extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'bankabilgileri';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int'
	];

	protected $fillable = [
		'BAYIKODU',
		'HESAPSAHIBI',
		'BANKAADI',
		'IBAN',
		'DURUM'
	];
}
