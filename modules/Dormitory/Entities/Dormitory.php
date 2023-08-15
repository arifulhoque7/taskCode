<?php

namespace Modules\Dormitory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dormitory extends Model
{
    use HasFactory;
    
    protected $fillable = ['dormitory_name',
    'type',
    'address'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function rooms()
    {
        return $this->hasMany(Room::class,'dormitories_id');
    }


}
