<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class caoCliente extends Model
{
    protected $table = "cao_cliente";

    protected $fillable = ['co_cliente','no_razao'];

    public function client_sign()
    {
        return $this->belongsTo(File::class, 'client_sign_id');
    }
    
}
