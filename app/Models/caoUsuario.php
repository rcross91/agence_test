<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class caoUsuario extends Model
{
    protected $table = "cao_usuario";

    protected $fillable = ['co_usuario','co_tipo_usuario','co_sistema'];

    public function client_sign()
    {
        return $this->belongsTo(File::class, 'client_sign_id');
    }
    
}
