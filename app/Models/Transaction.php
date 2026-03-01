<?php

namespace App\Models;

use App\Presenters\DefaultPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Transaction extends Model
{
    use PresentableTrait, SoftDeletes;

    protected string $presenter = DefaultPresenter::class;
    protected $fillable = ['user_id', 'archive_id', 'cpf', 'status', 'value'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function archive(): BelongsTo
    {
        return $this->belongsTo(Archive::class, 'archive_id', 'id');
    }
}
