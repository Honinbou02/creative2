<?php

namespace App\Services\Model\ChatExpert;

use App\Models\ChatExpert;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatExpertService.
 */
class ChatExpertService
{
    public function all() {
        $request  = request();
        $search   = $request->search;

        $query = ChatExpert::query()->filters()->where('type', 'chat');

        return $query->latest()->paginate(request('perPage', appStatic()::PER_PAGE_DEFAULT), "*", "page", request('page', 0))->withQueryString();
    }

    public function getAll(
        $isPaginateOrGet = false,
        $isActiveOnly = null,
        $type = null
    )
    {
        $query = ChatExpert::query()->when($type, function($q) use ($type){
            $q->where('type', $type);
        });

        // when is Paginate or Get contain null
        if(is_null($isPaginateOrGet)) {
            return  $query->pluck("expert_name", "id");
        }

        if(!is_null($isActiveOnly)) {
            $query->isActive($isActiveOnly);
        }


        return $isPaginateOrGet ? $query->paginate(maxPaginateNo()) : $query->get();
    }

    /**
     * Expert Store
     * */
    public function store($payloads) : Model {
        $payloads['type'] = 'chat';
        return ChatExpert::query()->create($payloads);
    }

    /**
     * Expert Update
     * */
    public function update($chatExpert, $payloads) : Model {
        $chatExpert->update($payloads);

        return $chatExpert;
    }

    /**
     * Expert info
     * */
    public function getChatExpertById($id, $isFirstOnly = true) {
        $query =  ChatExpert::query();

        return $isFirstOnly ? $query->find($id) : $query->findOrFail($id);
    }

}
