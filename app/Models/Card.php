<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'column_id',
        'title',
        'description',
        'order',
    ];

    /**
     * @return BelongsTo
     */
    public function column(): BelongsTo
    {
        return $this->belongsTo(Column::class);
    }
}
