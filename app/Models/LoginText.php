<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginText extends Model
{
    use HasFactory;

    protected $primaryKey = 'login_text_id';

    protected $fillable = ['text'];

}
