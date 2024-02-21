<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Basket extends Model
{
    use HasFactory;

    
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('item_id', '=', $this->getAttribute('item_id'));

        return $query;
    }

    public function kosar()
    {    return $this->hasMany(Basket::class, 'item_id', 'item_id');   }

    public function user()
    {  return $this->belongsTo(User::class, 'id', 'id');   }


}
