<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketRequisition extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table="packet_requisitions";

    public function user() {
        return $this->belongsTo(User::class);
    }
}
