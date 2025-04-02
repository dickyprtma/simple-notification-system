<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'temp',
    ];

    /**
     * Get the user that owns the coop.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
