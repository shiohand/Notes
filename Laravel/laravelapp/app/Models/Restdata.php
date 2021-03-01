<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restdata extends Model
{
    use HasFactory;

    protected $table = 'restdata';
    protected $guarded = ['id'];

    public static $rules = [
        'message' => 'required',
        'url' => 'required',
    ];

    public function getData()
    {
        return $this->id.': '.$this->message.' ('.$this->person->url.')';
    }
}
