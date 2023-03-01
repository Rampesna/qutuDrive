<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Kullanicimacadre
 *
 * @property int $ID
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $MACADRES
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Kullanicimacadre extends BaseModel
{
    use SoftDeletes;

	protected $table = 'kullanicimacadres';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'DURUM' => 'int'
	];

	protected $fillable = [
		'KULLANICIAPIKEY',
		'MACADRES',
		'DURUM'
	];
}
