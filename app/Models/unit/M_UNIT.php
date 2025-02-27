<?php

namespace App\Models\unit;

use Illuminate\Database\Eloquent\Model;

class M_UNIT extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'unit_id';
    protected $fillable = ['unit_id', 'waktu_diuabh','waktu_dibuat','dibuat_oleh','diubah_oleh','status'];
    public $timestamps = false;

}
