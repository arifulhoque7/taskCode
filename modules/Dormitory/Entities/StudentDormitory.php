<?php

namespace Modules\Dormitory\Entities;

use App\Models\User;
use Modules\Dormitory\Entities\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Dormitory\Entities\Dormitory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentDormitory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',
    'dormitories_id',
    'room_id' ];
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }
    public function room()
    {
        return $this->belongsTo(Room::class,'room_id','id');
    }
    public function dorm()
    {
        return $this->belongsTo(Dormitory::class,'dormitories_id','id');
    }
    public function student()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
