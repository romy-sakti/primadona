<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peraturan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peraturans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'judul',
		'nomor_peraturan',
		'tahun',
		'keterangan',
        'file_peraturan',
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
     * Get the file URL attribute
     *
     * @return string|null
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_peraturan) {
            return asset('storage/peraturan/' . $this->file_peraturan);
        }
        return null;
    }
}