<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Dosyasunucubilgileri
 *
 * @property string $GUID
 * @property string|null $SUNUCUTURKODU
 * @property string|null $SUNUCUURL
 * @property string|null $SUNUCUACCESSKEY
 * @property string|null $SUNUCUSECRETKEY
 * @property int|null $AKTIF
 *
 * @package App\Models
 */
class Dosyasunucubilgileri extends BaseModel
{
//    use SoftDeletes;

	protected $table = 'dosyasunucubilgileri';
	protected $primaryKey = 'GUID';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'AKTIF' => 'int'
	];

	protected $fillable = [
		'SUNUCUTURKODU',
		'SUNUCUURL',
		'SUNUCUACCESSKEY',
		'SUNUCUSECRETKEY',
		'AKTIF'
	];
}
