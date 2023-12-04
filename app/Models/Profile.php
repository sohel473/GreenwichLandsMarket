<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'telephone',
        'photograph',
        'address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        // other casts if necessary
    ];

    /**
     * Get the user associated with the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the full name of the user.
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    protected function photograph(): Attribute {
        return Attribute::make(
            get: function($value) {
                return $value ? '/storage/photographs/' . $value : '/default_pic.jpg';
            }
        );
    }
}
