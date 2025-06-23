
  
<div class="py-2 border-bottom pb-0 d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">
    <div class="col-auto flex-grow-1">
        <input class="form-control border-0 px-2 form-control-sm" type="hidden" id="content_id" value="{{$content->id}}">
        <input class="form-control border-0 px-2 form-control-sm" type="text" id="title" value="{{isset($content) ? $content->title : ''}}" placeholder="{{localize('Name of the document...')}}">
    </div>
    <div class="tt-chat-action d-flex align-items-center">
        <div class="dropdown tt-tb-dropdown me-2">
            <button type="button" class="btn p-0 copyChat me-1"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ localize('Copy') }}"><i data-feather="copy" class="icon-16"></i></button>
            <button type="button" class="btn p-0 move_to_folder_btn" data-bs-toggle="offcanvas" data-bs-target="#addMoveToFolderFormSidebar"><i data-feather="folder" class="icon-16"></i></button>
        </div>
    </div>
</div>
<div id="contentGenerator">
    {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<h3 class="mb-0 mt-4 h5">$1</h3>', $content->response)) !!}
</div>
<div class="d-flex justify-content-between gap-3 px-3 align-items-center">
    <div>
        <button class="btn btn-primary px-3 py-1 rounded-pill saveChange" {{isset($content) ? '' :'disabled'}} id="saveChangeBtn"> <i data-feather="save" class="icon-14"></i> {{localize('Save Content')}}</button>
    </div>
</div>
