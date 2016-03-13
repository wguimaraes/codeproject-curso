<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'status',
        'progress',
        'due_date',
    ];
    
    public function client(){
        return $this->belongsTo(Client::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'owner_id');
    }
    
    public function notes(){
        return $this->hasMany(ProjectNote::class);
    }

}
