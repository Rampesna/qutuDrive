<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Versiyontakip
 *
 * @property int $ID
 * @property int|null $TURKODU
 * @property int|null $VERSIYON
 *
 * @package App\Models
 */
class Versiyontakip extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'versiyontakip';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'TURKODU' => 'int',
		'VERSIYON' => 'int'
	];

	protected $fillable = [
		'TURKODU',
		'VERSIYON'
	];
}
