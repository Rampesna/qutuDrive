<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Syncklasorler
 *
 * @property string $ID
 * @property string|null $FIRMAAPIKEY
 * @property string|null $KULLANICIAPIKEY
 * @property string|null $KLASORADI
 * @property string|null $KAYNAKADI
 * @property string|null $KAYNAKBILGISAYARADI
 * @property string|null $KAYNAKKLASORYOLU
 * @property int|null $AKTIF
 * @property string|null $DOSYAFILITRE
 *
 * @package App\Models
 */
class Syncklasorler extends Model
{
    use SoftDeletes;

	protected $table = 'syncklasorler';
	protected $primaryKey = 'ID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'AKTIF' => 'int'
	];

	protected $fillable = [
		'FIRMAAPIKEY',
		'KULLANICIAPIKEY',
		'KLASORADI',
		'KAYNAKADI',
		'KAYNAKBILGISAYARADI',
		'KAYNAKKLASORYOLU',
		'AKTIF',
		'DOSYAFILITRE'
	];
}
