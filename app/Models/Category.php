<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // use HasFactory;
    protected $fillable = ['tulajdonos', 'auto', 'garancialis', 'eletkor', 'szerviz_kezdete', 'szerviz_vege'];
}
