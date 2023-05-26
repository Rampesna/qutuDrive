<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sanalposbilgileri
 *
 * @property int $ID
 * @property string|null $AKTIFPOS
 * @property string|null $KULLANICIKODU
 * @property string|null $APIKULLANICIADI
 * @property string|null $APISIFRE
 * @property string|null $BAYIKODU
 *
 * @package App\Models
 */
class Sanalposbilgileri extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'sanalposbilgileri';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $fillable = [
		'AKTIFPOS',
		'KULLANICIKODU',
		'APIKULLANICIADI',
		'APISIFRE',
		'BAYIKODU'
	];
}
