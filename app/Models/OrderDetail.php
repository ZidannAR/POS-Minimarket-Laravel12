<?php

// app/Models/OrderDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table='order_detail';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['order_id', 'id_produk', 'harga', 'jumlah'];
}

