<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BootTrait\CreatedByUpdatedByIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BootTrait\CreatedUpdatedByRelationshipTrait;

class ClientFeedback extends Model
{
    use HasFactory;
    use CreatedByUpdatedByIdTrait;
    use CreatedUpdatedByRelationshipTrait;
    protected $fillable = [
        "name",
        "avatar",
        "designation",
        "heading",
        "rating",
        "review",
        "user_id",
        "created_by_id",
        "updated_by_id"
    ];
    public function scopeFilters($query)
    {
        $request = request();

        // Search
        if ($request->has("search")) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return $query;
    }
}
