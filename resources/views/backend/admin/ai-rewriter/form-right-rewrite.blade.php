<div class="content-generator__body-header">
    <div
            class="p-3 py-2 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header d-none">


        <div class="col-auto flex-grow-1">
            <input
                    class="form-control border-0 px-2 form-control-sm"
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Name of the document..."
            />

            <input
                    class="form-control border-0 px-2 form-control-sm"
                    type="hidden"
                    id="writter_id"
                    name="writter_id"
            />
        </div>

        <div class="tt-chat-action d-flex align-items-center">
            <div class="dropdown tt-tb-dropdown me-2">
                <a href="#" class="overly-btn overly-delete bg-white text-light moveToFolder" data-bs-toggle="offcanvas"
                   data-bs-target="#offcanvasMoveToFolder">
                    <span title="{{localize('Move To Folder')}}"><i data-feather="folder" class="icon-14 text-black"></i></span>
                </a>
            </div>
            <div class="dropdown tt-tb-dropdown me-2">
                <button type="button" class="btn p-0 copyChat"><i data-feather="copy"
                                                                  class="icon-16"></i></button>
            </div>
            <div class="dropdown tt-tb-dropdown me-2">
                <button class="btn p-0" id="navbarDropdownUser" role="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside"
                        aria-haspopup="true" aria-expanded="true">
                    <i data-feather="download" class="icon-16"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow">
                    <a class="dropdown-item downloadChatBtn" href="javascript:void(0);" data-download_type="pdf">
                        <i data-feather="file" class="me-2"></i> {{localize('PDF')}}
                    </a>
                    <a class="dropdown-item downloadChatBtn" href="javascript:void(0);" data-download_type="html">
                        <i data-feather="code" class="me-2"></i> {{localize('HTML')}}
                    </a>
                    <a class="dropdown-item downloadChatBtn" href="javascript:void(0);" data-download_type="word">
                        <i data-feather="file-text" class="me-2"></i>{{localize('MS Word')}}
                    </a>
                </div>
            </div>
            <div class="dropdown tt-tb-dropdown me-2">
                <button type="button" class="btn p-0 saveChange"><i data-feather="save"
                                                                    class="icon-16"></i></button>
            </div>
        </div>
    </div>
</div>
