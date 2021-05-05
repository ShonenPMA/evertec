<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function getRealStatusAttribute()
    {
        $state = 'CREADO';
        switch ($this->status) {
            case 'PAYED':
                $state = 'PAGADO';
                break;
            case 'REJECTED':
                $state = 'RECHAZADO';
                break;
            default:
                $state = 'PENDIENTE';
                break;
        }

        return $state;
    }

    public function scopeSearch($query, $code)
    {
        return $query->where('code', $code);
    }
}
