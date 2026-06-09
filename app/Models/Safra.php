<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Safra extends Model
{
    protected $table = 'safras';

    protected $fillable = [
        'lote_codigo',
        'cooperado_nome',
        'safra_tipo',
        'safra_quantidade',
        'classificacao',
        'status'
    ];
}