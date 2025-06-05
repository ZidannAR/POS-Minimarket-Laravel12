<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $fillable = ['invoice', 'total', 'diskon', 'id_customers','status_member'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}

