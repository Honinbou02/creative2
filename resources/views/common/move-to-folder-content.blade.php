<div class="mb-3">
    <input type="hidden" value="{{$model}}" name="model">
    <input type="hidden" value="{{$model_id}}" name="model_id">
    <x-form.label for="folder_id" label="{{ localize('Folder') }}" />
    <x-form.select name="folder_id" id="folder_id">
        @foreach ($folders as $folderId => $name)
            <option value="{{ $folderId }}">{{ $name }}</option>
        @endforeach
    </x-form.select>
</div>