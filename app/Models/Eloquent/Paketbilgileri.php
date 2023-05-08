<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Paketbilgileri
 *
 * @property int $ID
 * @property string|null $BAYIKODU
 * @property string|null $PAKETKODU
 * @property string|null $PAKETADI
 * @property float|null $PAKETBOYUTU
 * @property float|null $PAKETFIYATI
 * @property int|null $DURUM
 *
 * @package App\Models
 */
class Paketbilgileri extends BaseModel
{
    use SoftDeletes;

	protected $table = 'paketbilgileri';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'PAKETBOYUTU' => 'float',
		'PAKETFIYATI' => 'float',
		'DURUM' => 'int'
	];

	protected $fillable = [
		'BAYIKODU',
		'PAKETKODU',
		'PAKETADI',
		'PAKETBOYUTU',
		'PAKETFIYATI',
		'DURUM'
	];
}
