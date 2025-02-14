<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonanmasyarakat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonanmasyarakats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'nama_pemohon',
		'jenis_permohonan_id',
		'nomor_perkara',
		'status_permohonan',
		'keterangan',
		'dokumen_penetapan',
		'nomor_telepon',
		'alamat_pemohon',
		'tempat_lahir',
		'tanggal_lahir',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * some columns model type
     *
     * @var array
     */
    const TYPES = [
	];

    /**
     * Default with relationship
     *
     * @var array
     */
    protected $with = [];

    /**
     * Get the jenis permohonan associated with the permohonan masyarakat.
     */
    public function jenisPermohonan()
    {
        return $this->belongsTo(Jenispermohonan::class, 'jenis_permohonan_id');
    }
}