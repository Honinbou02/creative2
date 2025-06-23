@extends('layouts.default')

@section('title')
    {{ localize('Template Content Generator ') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection

@section("pagetitle", localize('Generate Content'))

@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('AI Template')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('pageTitleButtons')
    @if(isCustomerUserGroup())
        @php
            $totalWordBalance     = userActivePlan()["word_balance"] ?? 0;
            $totalWordUsed        = userActivePlan()["word_balance_used"] ?? 0;
            $totalRemainingBalance = userActivePlan()["word_balance_remaining"] ?? 0;
        @endphp

        <div class="col-auto" id="balance-render">
            <x-common.balance-component :total="$totalWordBalance"
                                    :used="$totalWordUsed"
                                    :remaining="$totalRemainingBalance"
            />
        </div>
    @endif
    <div class="col-auto">
        <a href="{{ route('admin.templates.index') }}">
            <x-form.button type="button"><i data-feather="file-text"></i>{{localize('All Templates')}}</x-form.button>
        </a>
    </div>
@endsection

@section('content')
    <section class="tt-section pb-4">
        <div class="container">
            <div class="row">
                @if(isOpenAiEngine(templatesEngine()))
                    <x-common.open-ai-error/>
                @endif
                <div class="col-xl-12">
                    <div class="card border-0">

                        <div class="card content-generator flex-md-row">

                            <div class="content-generator__sidebar">
                                <div class="content-generator__sidebar-header pb-0 border-bottom">
                                    <h6> {{ $template->template_name }}</h6>       
                                </div>
                                <form action="{{ route('admin.templates.saveContent', $template->id) }}"
                                      data-route="{{ route('admin.templates.stream', $template->id) }}"
                                      method="GET" id="templateContentGenerator">
                                    @csrf
                                    <x-form.input type="hidden"
                                                  name="content_purpose"
                                                  value="{{appStatic()::PURPOSE_TEMPLATE_CONTENT}}"/>
                                    <x-form.input type="hidden"
                                                  name="template_id"
                                                  value="{{$template->id}}"
                                    />
                                    <div class="content-generator__sidebar-body overflow-y-auto tt-custom-scrollbar tt-screen-height">
                                        <div class="row g-3">
                                            <div class="col-12">

                                                <x-form.label for="language"
                                                              label="{{ localize('Select input and output language') }}"
                                                              isRequired=true />
                                                <x-form.select name="language" id="language">
                                                    @foreach (languages() as $language)
                                                        <option value="{{$language->name}}">{{$language->name}}</option>
                                                    @endforeach
                                                </x-form.select>
                                            </div>
                                             <x-form.input name="prompt" type="hidden"  :value="$template->prompt"/>
                                            @php
                                                $fields = !empty($template->fields) ? json_decode($template->fields, true) : [];
                                                $field_names = [];
                                            @endphp
                                          
                                            @forelse($fields as $key=>$field)
                                            @php
                                                $field_names[] = '{_'.$field["field"]["name"].'_}';
                                            @endphp
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <x-form.label for="element{{ $key }}"
                                                                      label="{{ $field['label'] }}"
                                                                      :isRequired="$field['is_required']"
                                                        />

                                                        @if($field["field"]["type"] == "textarea")
                                                            <x-form.textarea
                                                                    :name="$field['field']['name']"
                                                                    class="form-control"
                                                                    rows="8"
                                                            />
                                                        @else
                                                            <input
                                                                   placeholder="Ex. {{$field['field']['name']}}"
                                                                   class="form-control form-control-sm"
                                                                   type="{{ $field["field"]['type'] }}"
                                                                   name="{{ $field["field"]["name"] }}"
                                                            />
                                                        @endif

                                                    </div>

                                                </div>

                                            @empty

                                            @endforelse
                                            <input type="hidden" value="{{json_encode($field_names)}}" name="field_names">
                                            @if(templatesEngine() ==  appStatic()::ENGINE_OPEN_AI)
                                            <div class="col-12">
                                                <div class="text-left">
                                                    <div class="d-flex align-items-center tt-advance-options cursor-pointer">
                                                        <x-form.label
                                                                class="form-label cursor-pointer btn btn-sm btn-secondary rounded-pill fw-medium"
                                                                for="tt-advance-options">
                                                            <i class="las la-plus"></i>
                                                            {{ localize("Advance Options") }}
                                                        </x-form.label>
                                                    </div>

                                                    <div class="toggle-next-element__is bg-secondary bg-opacity-50 p-lg-4 p-2 rounded-3 tt-advance-options-content">
                                                        <div class="row g-3">
                                                            <div class="col-12">

                                                                <x-form.label for="max_tokens"
                                                                              label="{{ localize('Max Content Length') }}" />
                                                                <x-form.input type="text" name="max_tokens"
                                                                              class="form-control form-control-sm"
                                                                              id="maxArticleLength" placeholder="10" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <x-form.label for="tone"
                                                                              label="{{ localize('Choose a Tone') }}" />
                                                                <x-form.select name="tone"
                                                                               class="form-select form-select-transparent form-select--sm"
                                                                               id="tone">
                                                                    @foreach (appStatic()::OPEN_AI_TONE as $key => $item)
                                                                        <option value="{{ $key }}">
                                                                            {{ localize($item) }}</option>
                                                                    @endforeach

                                                                </x-form.select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <x-form.label for="creativity"
                                                                              label="{{ localize('Creativity') }}" isRequired=true />
                                                                <x-form.select name="creativity"
                                                                               class="form-select form-select-transparent form-select--sm"
                                                                               id="creativity">

                                                                    @foreach (appStatic()::OPEN_AI_CREATIVITY as $key => $name)
                                                                        <option value="{{ (int) $key }}">
                                                                            {{ localize($name) }}</option>
                                                                    @endforeach

                                                                </x-form.select>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="content-generator__sidebar-footer py-3">
                                        <div class="d-flex align-items-center row-gap-2 column-gap-3 flex-wrap">
                                            <x-form.button class="btn btn-sm btn-primary rounded-pill" type="submit" id="generateContent">
                                                <i data-feather="rotate-cw" class="icon-12"></i>
                                                {{ localize('Generate Content') }}
                                            </x-form.button>
                                            <x-form.button class="btn btn-sm btn-secondary rounded-pill StopGenerate" disabled id="stopGenerateContent">
                                                <i data-feather="stop-circle" class="icon-14"></i>
                                                {{ localize('Stop Generation') }}
                                            </x-form.button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="content-generator__body">
                                <div class="content-generator__body-header">
                                    <div class="p-3 py-2 border-bottom d-flex flex-wrap gap-2 align-items-center justify-content-between bg-light-subtle tt-chat-header">
                                        <div class="col-auto flex-grow-1">
                                            <input class="form-control border-0 px-2 form-control-sm" type="text"
                                                   id="name" name="name" placeholder="Name of the document...">
                                            <input class="form-control border-0 px-2 form-control-sm" type="hidden"
                                                   id="generated_id" name="generated_id">
                                        </div>
                                        <div class="tt-chat-action d-flex align-items-center">
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
                                                <button type="button" class="btn p-0 saveChange" ><i data-feather="save"
                                                                                          class="icon-16"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-generator__body-content">
                                    <div id="contentGenerator" class="contentGenerator"></div>

                                </div>
                                <div class="d-flex justify-content-end mt-4 mb-3 px-3">
                                    <x-form.button class="px-3 py-1 rounded-pill saveChange"  id="saveChangeButton" disabled color="outline-primary">
                                        <i data-feather="save" class="icon-14"></i>
                                        {{localize('Save Changes')}}
                                    </x-form.button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('backend.admin.template.js')
@endpush
