<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Group extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name', 'user_id', 'institution_id'];

	public function getTotalValueAttribute()
	{
		return $this->movements()->applications()->sum('value') - $this->movements()->outflows()->sum('value');
	}

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        // RELACIONAMENTO N:N
        return $this->belongsToMany(User::class, 'user_groups');
    }


    public function institution()
    {
    	return $this->belongsTo(Institution::class);
	}
	
	public function movements()
	{
		return $this->hasMany(Movement::class);
	}

}
