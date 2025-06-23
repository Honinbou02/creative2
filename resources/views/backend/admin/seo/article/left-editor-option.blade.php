<div class="p-3 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">


    <div class="col-auto flex-grow-1">
        <x-form.input
                class="form-control border-0 px-2 form-control-sm"
                type="text"
                id="text-input"
                name="title"
                value="{{ $article->title ?? $article->topic }}"
                placeholder="Name of the document..."
        />
    </div>
    <div class="tt-chat-action d-flex align-items-center">

    </div>
</div>