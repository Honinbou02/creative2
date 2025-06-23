<?php

namespace Modules\SocialPilot\App\Services\QuickText;

use Modules\SocialPilot\App\Models\QuickText;

class QuickTextService
{
    public function index($getAll = false)
    {
        $request         = request();
        $quickTexts      = QuickText::filterByUser();
        
        if($request->has('search')){
            $quickTexts->where('title', 'like', '%'.$request->search.'%')->orWhere('description', 'like', '%'.$request->search.'%');
        }

        if ($getAll) {
            $quickTexts       = $quickTexts->get();
        }else{
            $quickTexts       = $quickTexts->paginate(maxPaginateNo());
        }
        $data['details'] = $quickTexts;
        return $data;
    } 

    public function findById($id)
    {
        return QuickText::findOrFail((int) $id);
    }

    public function store($request)
    {
        $quickText                  = new QuickText();
        $quickText->title           = $request->title;
        $quickText->description     = $request->description;
        $quickText->user_id         = userID();
        $quickText->save();

        return $quickText;
    }

    public function update($request)
    {
        $request = request();
        $quickText                  = $this->findById((int) $request->id);
        $quickText->title           = $request->title;
        $quickText->description     = $request->description;
        $quickText->save();

        return $quickText;
    }
}
