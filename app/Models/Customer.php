<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customers';
    protected $primaryKey = 'id_customers';

    protected $fillable = ['nama', 'no_hp', 'status_member', 'poin','tanggal_daftar'];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];


    public function transactions()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    
    public function isMember()
    {
        return $this->status_member;
    }
}
