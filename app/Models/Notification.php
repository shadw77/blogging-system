<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [ 'id','data', 'notifiable_id', 'type', 'notifiable_type'];
}