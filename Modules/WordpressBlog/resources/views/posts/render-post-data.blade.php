<div class="wordpressBlogRow" id="wordpressBlogRow">
    <input type="hidden" value="{{$article_id}}" name="article_id" />
    <input type="hidden" name="wp_post_id" value="{{ $wp_post_id }}" />
    
    <x-common.message class="mb-3" />
    <div class="row g-3">
        <div class="col-md-12 col-12 alert alert-secondary mb-0">
            @php
                $labelText = !empty($article->wp_synced_at) ? manageDateTime($article->wp_synced_at, 7) : localize('Not Synced Yet');
            @endphp
            <x-info-message labelTitle="{{ localize('Last Synced with WordPress') }}" labelText="{{ $labelText }}" show_small='' />
        </div>

        <div class="col-md-12 col-12">
            <x-form.label for="push_post_type" label="{{ localize('Select Post Type as a') }}:" isRequired=true />
            <x-form.select name="push_post_type">
                @if ($wp_post_id)<option value="1">{{ localize("Existing Post") }}</option>@endif
                <option value="2">{{ localize("New Post") }}</option>
            </x-form.select>
        </div>

        <div class="col-md-12 col-12">
            <x-form.label for="status" label="{{ localize('Post Status') }}:" isRequired=true />
            <x-form.select name="status" id="status">
                @foreach (WP_STATUS as $type => $title)
                    <option value="{{ $type }}">{{ $title }}</option>
                @endforeach
            </x-form.select>
        </div>
        
        <div class="col-12 futureDate d-none">
            <x-form.label for="futureDate" label="{{ localize('Schedule Post Date Time') }}:" isRequired=true />
            <x-form.input type="datetime-local" name="date" id="futureDate" date-format="Y-m-d H:i:s" />
        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <x-form.label for="categories[]" label="{{ localize('Category') }}:" isRequired=true />
                <div class="d-block">
                    <a href="{{ route('admin.blog-categories.index') }}" class="bg-soft-primary py-0 px-1 rounded text-dark" id="syncAllTags" target="__blank"> <i data-feather="refresh-cw" class="me-1 icon-12"></i> <span id="syncText" class="fs-sm">{{ localize('Sync Category') }}</span> </a>
                    {{-- <span class="cursor-pointer ms-2"> <i data-feather="info" class="icon-14" data-bs-toggle="tooltip" data-bs-placement="left" title="Your text"></i></span> --}}
                </div>
            </div>
            <x-form.select name="categories[]" class="select2" id="wp_categories" multiple>
                @foreach ($categories ?? [] as $item)
                    <option value="{{ $item->wp_id }}">
                        {{ $item->category_name }}
                    </option>
                @endforeach
            </x-form.select>
        </div>

        <div class="col-12">
            <x-form.label for="tags[]" label="{{ localize('Tags') }}:" isRequired=true />
            <x-form.select name="tags[]" class="select2" id="wp_tags" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->wp_id }}">{{ $tag->name }}</option>
                @endforeach
            </x-form.select>
        </div>

        <div class="col-md-12 col-12">
            <x-form.label for="author" label="{{ localize('Author') }}:" isRequired=true />
            <x-form.select name="author" id="author">
                @foreach ($authors as $authorId => $authorName)
                    <option value="{{ $authorId }}">{{ $authorName }}</option>
                @endforeach
            </x-form.select>
        </div>

        <div class="col-md-12 col-12">
            <x-form.label for="website" label="{{ localize('Website to Push') }}:" isRequired=true />
            @foreach ($websites as $website)
                <li class="p-0 d-flex">
                    <input class="form-check-input cursor-pointer me-2"
                            name="website"
                            @checked($loop->first)
                            value="{{$website->id}}"
                            type="radio"
                            id="website{{ $website->id }}"
                            data-name="{{ $website->url }}">
                    <label for="website{{ $website->id }}" class="cursor-pointer">{{ $website->url }}</label>
                </li>
            @endforeach
        </div>
    </div>
</div>
