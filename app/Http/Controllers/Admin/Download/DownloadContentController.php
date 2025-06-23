<?php

namespace App\Http\Controllers\Admin\Download;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\GeneratedContent;
use Illuminate\Http\Request;

class DownloadContentController extends Controller
{
    public function index(Request $request)
    {

        try {
            $type = $request->type;
            if($request->article_id) {
                $project = Article::where('id', $request->article_id)->first();
                $data = ['slug' => slugMaker($project->topic), 'content'=>$project->article, 'type'=>$type];
                $slug = slugMaker($project->topic);
            }else {

                $project = GeneratedContent::where('id', $request->id)->where('user_id', auth()->user()->id)->first();
                $data = ['slug' => $project->slug, 'content'=>$project->response, 'type'=>$type];
                $slug =  $project->slug;
            }
            if(!$project) {
                flash(localize('Content not found for you'));
                return redirect()->back();
            }
          

            if($type == 'html') {
                $name =  $slug .'.html';
                 $file_path = public_path($name);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $view = view('download.content', $data)->render();
                file_put_contents($file_path, $view);
                return response()->download($file_path);


            }
            if($type == 'word') {
                $name =  $slug .'.doc';
                 $file_path = public_path($name);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                $view = view('download.content', $data)->render();
                file_put_contents($file_path, $view);
                return response()->download($file_path);
            }
            if($type == 'pdf') {
                return  view('download.content', $data);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
