<?php

namespace Modules\WordpressBlog\App\Http\Controllers\Auth;

use Faker\Provider\Lorem;
use App\Models\Permission;
use App\Utils\ResponseLab;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator as Faker;
use App\Services\Model\TagService;
use Illuminate\Support\Facades\DB;
use App\Services\Model\PostService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Services\Model\CategoryService;
use App\Services\Model\User\UserService;
use Modules\WordpressBlog\Services\WpBasicAuthService;

class WpBasicAuthController extends Controller
{
    public function connectWp(Request $request, WpBasicAuthService $wpBasicAuthService, ResponseLab $responseLab)
    {
        try{
            $connectWp = $wpBasicAuthService->connectWp();
    
            // Is Successful Communication : $isSuccess == true means successful connection
            $isSuccess = $responseLab->isWpIntegrated($connectWp);

            // When Credentials are wrong
            if(!$isSuccess){
                session()->flash("error", "Failed to integrate with WP. Please try again.");
                return redirect()->route("welcome")->with(["error" => "Failed to integrate with WP. Please try again."]);
            }

            session()->flash("success", "Successfully Integrated with WP. Now you can login.");

            return redirect()->route("welcome");
        }
        catch(\Throwable $e){
            wLog("Failed to connect WP", errorArray($e));
            session()->flash("error", "Failed to integrate with WP. ".$e->getMessage());

            return redirect()->back();
        }
    }


    /**
     * New Post Publish
     *
     * @incomingParams $title contains Post Title
     * @incomingParams $content contains Post Content
     * @incomingParams $status contains Post Status (draft, publish, future, pending, private)
     * @incomingParams $date contains Post Date (when date is future, it will be published on that date & status will be future automatically)
     * @incomingParams $author contains Post Author
     * @incomingParams $slug is the post slug
     * */
    public function uploadAPost(Request $request, WpBasicAuthService $wpBasicAuthService, Faker $faker, ResponseLab $responseLab)
    {
        try{
            $data = [
                "title"   => "Testing Date Future:". $faker->sentence(),
                "content" => $faker->paragraph(),
                "date"    => "2022-03-03 00:00:00",
                "status"  => "future",
                "author"  => 3,
                "tags"  => [4, 22],
                "slug"    => $faker->slug(),
                "excerpt" => $faker->paragraph(),
                "categories" => [9,20]
            ];

            $uploadPost = $wpBasicAuthService->uploadAPost(
                $data,
                [$wpBasicAuthService::BASIC_AUTH_USER, $wpBasicAuthService::BASIC_AUTH_PASSWORD]
            );

            // Is Successful Uploaded
            if($responseLab->isSuccessfulPost($uploadPost)){
                //TODO::POST UPLOAD
            }

            // Failed to Upload WP Post.
            // TODO::ERROR Logic Here
        }
        catch(\Throwable $e){
            wLog("Failed to upload a Post", errorArray($e));

            ddError($e);
            return redirect()->back();
        }
    }

    public function showPost($id, WpBasicAuthService $wpBasicAuthService, ResponseLab   $responseLab, Faker $faker)
    {
        try{
            $showPost = $wpBasicAuthService->showPost($id);
        }
        catch(\Throwable $e){

            wLog("Failed to retrieve post", errorArray($e));

            return redirect()->back();
        }
    }


    public function updatePost($id, WpBasicAuthService $wpBasicAuthService, ResponseLab   $responseLab, Faker $faker)
    {
        try{
            $data = [
                "title"   => "XYZ: ".$faker->sentence(),
                "content" => $faker->paragraph(),
                "status"  => "future",
                "date"    => "2024-03-03 00:00:00",
                "author"  => 3,
                "slug"    => $faker->slug(),
                "excerpt" => $faker->paragraph(),
                "categories" => [9,20]
            ];

            $updatePost = $wpBasicAuthService->updatePost($data, $id);

            // Is Successful Uploaded
            if($responseLab->isSuccessfulPost($updatePost)){
                //TODO::POST UPLOAD
            }

            // Failed to Update WP Post.
            // TODO::ERROR Logic Here
        }
        catch(\Throwable $e){
            wLog("Failed to retrive post", errorArray($e));

            return redirect()->back();
        }
    }


    public function getAllPosts(Request $request, WpBasicAuthService $wpBasicAuthService, ResponseLab   $responseLab)
    {
        try{
            $posts = $wpBasicAuthService->getPosts();

            // Success Communication is Array. Error is the object
            if(!is_array($posts)){
            }

            //TODO::POSTS LISTS
            return view("wp.posts.index", ["posts" => $posts]);
        }
        catch(\Throwable $e){
            \DB::rollBack();
            wLog("Failed to get all posts", errorArray($e));

            return redirect()->back();
        }
    }


    public function syncWp(
        Request $request,
        WpBasicAuthService $wpBasicAuthService,
        CategoryService $categoryService,
        TagService $tagService,
        UserService $userService,
        PostService $postService
    )
    {
        try{
            $syncOptions = $wpBasicAuthService->syncOptions(); // tags
            $sync        = $request->sync ?? 0; // 0
            $methodName  = "get".$syncOptions[$sync]; //getTags
            $syncDatas   = $wpBasicAuthService->$methodName();

            // When Something went wrong
            if(!is_array($syncDatas)){

            }

            // Category Sync
            if($sync == SYNC_CATEGORIES){
                $categoryService->storeUpdateCategories($syncDatas);
            }


            // Tags Sync
            if($sync == SYNC_TAGS){
                $tagService->storeUpdateTags($syncDatas);
            }


            // Category Sync
            if($sync == SYNC_CATEGORIES){
                $categoryService->storeUpdateCategories($syncDatas);
            }


            // Category Sync
            if($sync == SYNC_CATEGORIES){
                $categoryService->storeUpdateCategories($syncDatas);
            }




        }
        catch(\Throwable $e){
            DB::rollBack();
            wLog("", errorArray($e));

            ddError($e);
            return redirect()->back();
        }
    }




    public function continueStreaming(Request $request, $content = null)
    {


        $loremIpsum = Lorem::paragraph(1);
        $loremIpsum = empty($content) ? $loremIpsum : $content;

        return response()->stream(function () use ($loremIpsum) {
            echo $loremIpsum;
        }, 200, [
            'Content-Type'  => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection'    => 'keep-alive'
        ]);
    }


    public function streamLorem($content = null)
    {
        $loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";

        $loremIpsum = empty($content) ? $loremIpsum : $content;

        return response()->stream(function () use ($loremIpsum) {
            echo $loremIpsum;
        }, 200, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-cache',
        ]);
    }

}
