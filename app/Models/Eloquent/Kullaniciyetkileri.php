<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Kullaniciyetkileri
 *
 * @property int $ID
 * @property int|null $KULLANICIID
 * @property string|null $MODUL
 * @property string|null $YETKI
 * @property string|null $ROLADI
 *
 * @package App\Models
 */
class Kullaniciyetkileri extends Model
{
    use SoftDeletes;

	protected $table = 'kullaniciyetkileri';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'KULLANICIID' => 'int'
	];

	protected $fillable = [
		'KULLANICIID',
		'MODUL',
		'YETKI',
		'ROLADI'
	];
}
