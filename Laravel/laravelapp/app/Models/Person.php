<?php

namespace App\Models;

use App\Scopes\ScopePerson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
  use HasFactory;

  protected $guarded = array('id');

  public static $rules = array(
    'name' => 'required',
    'mail' => 'email',
    'age' => 'integer|min:0|max:150',
  );

  public function getData()
  {
    return $this->id.': '.$this->name.' ('.$this->age.')';
  }

  public function boards()
  {
    return $this->hasMany('App\Models\Board');
  }
}
