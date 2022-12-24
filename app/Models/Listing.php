<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title','company','location','website','email','tags','description','logo'];    

    public function scopeFilter($query, array $filters){
        //dd(request('tag'));
        if($filters['tag'] ?? false){   // if null don't do
            $query->where('tags','like','%' . request('tag') . '%');
        }

        if($filters['search'] ?? false){   // if null don't do
            $query->where('title','like','%' . request('search') . '%')
            ->orWhere('description','like','%' . request('search') . '%')
            ->orWhere('tags','like','%' . request('search') . '%');
        }
    }

    // Relationship to user
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
