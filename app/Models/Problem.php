<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Problem extends Model
{
    use HasFactory;

    const STATUS_OPENED = 0;
    const STATUS_ASSIGNED_PERFORMER = 1;
    const STATUS_CHECKING = 2;
    const STATUS_CLOSED = 3;

    const LOW_PRIORITY = 0;
    const MIDDLE_PRIORITY = 1;
    const HIGH_PRIORITY = 2;

    protected $fillable = ['user_id', 'performer_id',  'subcategory_id', 'place', 'description', 'commentary'];

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
