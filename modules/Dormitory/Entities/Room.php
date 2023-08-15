<?php

namespace Modules\Dormitory\Entities;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['room_number',
                            'room_type_id',
                            'no_of_beds',
                            'description',
                            'status'
                            ];

                            
    protected static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::created(function ($model) {
                $model->room_number = str_pad($model->id, 10, 0, STR_PAD_LEFT);
                $model->save();
            });
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class); 
    }
}
