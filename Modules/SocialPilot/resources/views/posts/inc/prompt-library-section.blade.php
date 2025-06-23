<div class="content-generator__sidebar bg-secondary-subtle">
    <div class="row g-3 p-3 d-none">
        <div class="col-auto flex-grow-1">
            <div class="tt-search-box w-auto">
                <div class="input-group">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                  data-feather="search" class="icon-16"></i></span>
                    <input class="form-control rounded-start form-control-sm" id="myInputTextField" type="text" placeholder="Search...">
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="input-group">
                <x-form.select name="prompt_group_id" id="prompt_group_id">
                    <option selected="">{{ localize('Select Group') }}</option>
                    @foreach ($groups as $key => $group)
                        <option value="{{ $key }}">{{ $group }}</option>
                    @endforeach
                </x-form.select>
            </div>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-dark btn-sm">
                <i data-feather="search" class="icon-14"></i>
                {{ localize('Search') }}
            </button>
        </div>
    </div>
    <div class="tt-custom-scrollbar overflow-y-auto tt-screen-height">
        <div class="p-3 py-2 border-bottom bg-light-subtle">
            <div class="fs-24 fw-bold">{{localize('Prompt Library')}}</div>
        </div>
        <ul class="content-generator__sidebar-body list-unstyled">
            @foreach ($groupPrompts as $prompt)
                <li class="promptBtn mb-2" data-prompt="{!! $prompt->description !!}">
                    <div class="tt-prompt-single-content p-3 rounded shadow-sm card">
                        <h3 class="h6 mb-1">{{ $prompt->name }}</h3>
                        <p class="fs-md">{{ $prompt->description }}
                    </div>
                </li>
            @endforeach
            {{ paginationFooterDiv($groupPrompts) }}
        </ul>
    </div>
</div>