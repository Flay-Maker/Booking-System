<?php

namespace App\Models;
    
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings'; // match the existing table
    protected $fillable = ['fullname','gender', 'number', 'date', 'time', 'status'];
    public $timestamps = true; // if your table has created_at and updated_at
}