<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Firmakullanicibaglanti
 *
 * @property int $ID
 * @property int|null $FIRMAID
 * @property int|null $KULLANICIID
 * @property string|null $FIRMAUNVAN
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Firmakullanicibaglanti extends BaseModel
{
    use SoftDeletes;

	protected $table = 'firmakullanicibaglanti';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'FIRMAID' => 'int',
		'KULLANICIID' => 'int',
		'DURUM' => 'int'
	];

	protected $fillable = [
		'FIRMAID',
		'KULLANICIID',
		'FIRMAUNVAN',
		'DURUM'
	];
}
