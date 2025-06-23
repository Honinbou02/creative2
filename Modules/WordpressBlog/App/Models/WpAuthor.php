<?php

namespace Modules\WordpressBlog\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WpAuthor extends Model
{
    use HasFactory;
    protected $table = "wp_authors";

    protected $fillable = [
        "wp_user_id",
        "name",
        "email",
        "username",
        "first_name",
        "last_name",
        "user_site_id",
        "user_id",
        "created_by_id",
        "updated_by_id"
    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function site() : BelongsTo
    {
        return $this->belongsTo(UserSite::class, "user_site_id");
    }

    #Scope

    public function scopeFilters($query)
    {
        $request = request();

        // Search
        if($request->has("search") && !empty($request->search)){
            $search = $request->search;
            $query->where(function($query) use ($search){
                $query->where("name", "like", "%{$search}%")
                    ->orWhere("username", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%");
            });
        }
    }

}
