<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class caoFatura extends Model
{
    protected $table = "cao_fatura";

    protected $fillable = ['co_fatura','co_cliente','co_sistema'];

    public function client_sign()
    {
        return $this->belongsTo(File::class, 'client_sign_id');
    }
    
}
