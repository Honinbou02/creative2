<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Wp\Author;

use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\WordpressBlog\App\Services\Action\WpUserActionService;

class WpAuthorController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $data["lastSyncTime"] = (new WpUserActionService())->getLastSyncTime(getUserObject());
        if($request->ajax()){

            $data["lists"] = (new WpUserActionService())->getWpAuthorList(["user_id" => getUserObject()->id], ["paginate" => true]);

            return view('wordpressblog::authors.render.author-list')->with($data)->render();
        }

        return view('wordpressblog::authors.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wordpressblog::create');
    }

    public function syncAllUsers(Request $request, WpUserActionService $wpUserActionService)
    {
        try{
            $users = $wpUserActionService->syncWpUsersByUser(getUserObject());

            flashMessage(localize("Successfully synced all users."), "success");

            return $this->sendResponse(
              appStatic()::SUCCESS_WITH_DATA,
              localize("Successfully synced all users."),
              $users
            );
        }
        catch(\Throwable $e){
            \DB::rollBack();
            wLog("Failed to sync all users",  errorArray($e));

            return $this->sendResponse(
                appStatic()::NOT_FOUND,
                localize("Failed to sync all users."),
                [],
                errorArray($e)
            );
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('wordpressblog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('wordpressblog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
