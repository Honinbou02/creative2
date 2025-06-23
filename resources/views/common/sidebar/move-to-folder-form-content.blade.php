<form action="" method="POST" class="move-to-folder-form">
    @csrf
    <input type="hidden" name="id" id="content_id" value="{{ $content->id }}">
    <div class="form-input">
        <label for="folder_id" class="form-label">{{ localize('Folder') }}</label>
        <select class="form-select modalSelect2" id="folder_id" name="folder_id">
            <option value="" @if ($content->folder_id == null) selected @endif>{{ localize('All Documents') }}
            </option>
            @foreach ($folders as $key => $folder)
                <option value="{{ $key }}" @if ($content->folder_id == $key) selected @endif>
                    {{ $folder }}</option>
            @endforeach
        </select>
    </div>

    <div class="d-flex justify-content-between mt-3 align-items-center">
        <div>
            <button class="btn btn-primary px-3 py-1 moveToFolder" id="moveToFolderBtn"> <i data-feather="save" class="icon-14"></i> {{localize('Save Changes')}}</button>
        </div>
    </div>
    
</form>
