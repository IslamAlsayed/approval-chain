<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status'];

    public function approval()
    {
        return $this->hasOne(Approval::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i A');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($project) {
            Approval::create(['project_id' => $project->id]);
        });
    }
}
