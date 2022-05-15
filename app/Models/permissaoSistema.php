<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissaoSistema extends Model
{
    protected $table = "permissao_sistema";

    protected $fillable = ['co_usuario','no_usuario','ds_senha'];

    public function client_sign()
    {
        return $this->belongsTo(File::class, 'client_sign_id');
    }
    
}
