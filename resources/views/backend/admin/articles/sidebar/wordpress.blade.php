@if (isModuleActive('WordpressBlog'))
    <div class="wordpressBlogRow" id="wordpressBlogRow">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="">
                            <h6>{{ localize('Published Website') }}</h6>
                        </label>
                        @isset($websites)
                            @foreach ($websites as $website)
                                <li class="p-0 d-flex">
                                    <input class="form-check-input cursor-pointer me-2" name="website"
                                           value="{{ $website->id }}" type="checkbox"
                                           id="website{{ $website->id }}" data-name="{{ $website->domain }}">
                                    <label for="website{{ $website->id }}"
                                           class="cursor-pointer">{{ $website->domain }}</label>
                                </li>
                            @endforeach
                        @endisset

                    </div>
                    <h6>{{ localize('Category') }}</h6>
                    <div class="col-12">
                        @isset($categories)
                            @foreach ($categories as $item)
                                <li class="p-0 d-flex">
                                    <input class="form-check-input cursor-pointer me-2" name="categories[]"
                                           value="{{ $item->wp_id }}" type="checkbox"
                                           id="category{{ $item->wp_id }}"
                                           data-name="{{ $item->category_name }}">
                                    <label for="category{{ $item->wp_id }}"
                                           class="cursor-pointer">{{ $item->category_name }}</label>
                                </li>
                            @endforeach
                        @endisset


                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-6 mb-3">
                        <x-form.label for="status" label="{{ localize('Status') }}" isRequired=true />
                        <x-form.select name="status" id="status">
                            @foreach (WP_STATUS as $type => $title)
                                <option value="{{ $type }}">{{ $title }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                    <div class="col-6 mb-3">
                        <x-form.label for="author" label="{{ localize('Author') }}" isRequired=true />
                        <x-form.select name="author" id="author">
                            @isset($authors)
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            @endisset

                        </x-form.select>
                    </div>
                    <div class="col-12 mb-3">
                        <x-form.label for="tags[]" label="{{ localize('Tags') }}" isRequired=true />
                        <x-form.select name="tags[]" class="select2" id="wp_tags" multiple>

                            @isset($tags)
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->wp_id }}">{{ $tag->name }}</option>
                                @endforeach
                            @endisset
                        </x-form.select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif