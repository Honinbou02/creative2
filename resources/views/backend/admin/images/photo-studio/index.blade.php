@extends("layouts.default")

@section('title')
    {{ localize('AI Photo Studio') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize("AI Photo Studio"))

@section("breadcrumb")
    @php
        $breadcrumbItems = [
        ["href" => null, "title" => localize("AI Image List")]
        ];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection


@section("pageTitleButtons")
    @if(isCustomerUserGroup())
        @php
            $totalImageBalance     = userActivePlan()["image_balance"] ?? 0;
            $totalImageUsed        = userActivePlan()["image_balance_used"] ?? 0;
            $totalRemainingBalance = userActivePlan()["image_balance_remaining"] ?? 0;
        @endphp

        <div class="col-auto" id="balance-render">
            <x-common.balance-component :total="$totalImageBalance"
                                        :used="$totalImageUsed"
                                        :remaining="$totalRemainingBalance"
            />
        </div>
    @endif
    <div class="col-auto">
        <a href="{{ route('admin.images.index') }}" class="btn btn-primary btn-sm">
            <i data-feather="image"></i> {{ localize("All Images") }}
        </a>
    </div>
@endsection

@section("content")
    <!-- Page Content  -->
    <div class="tt-page-content mb-4">
        <div class="container">
            <div class="row">
            <div class="col-12">
                    <div class="card">
                       <div class="card-body">
                           <form action="{{ route('admin.images.photoStudio.generatePhotoStudioImage') }}" enctype="multipart/form-data" method="POST">
                               @csrf
                               <div class="row">
                                   <div class="col-lg-12">
                                       <div class="form-group">
                                           <label for="title">{{ localize('Select Action') }} <span class="text-danger">*</span></label>
                                           <x-form.select name="action">
                                               @forelse($photoStudioArr as $key=>$value)
                                                   <option value="{{ $key }}" @selected($key == old('action')) >{{ $value }}  {{ getClipDropNote($key) }}  </option>
                                               @empty
                                               @endforelse
                                           </x-form.select>
                                       </div>
                                   </div>

                                   <div class="col-lg-12 uploadImageDiv">
                                       <div class="form-input">
                                           <label for="upload" class="form-label">{{ localize("Upload Image") }}</label>
                                           <div class="file-drop-area file-upload text-center rounded-3 mb-5">
                                               <x-form.input
                                                       type="file"
                                                       class="file-drop-input"
                                                       name="image_file" />
                                               <div class="file-drop-icon ci-cloud-upload">
                                                   <i data-feather="image"></i>
                                               </div>
                                               <p class="mb-0 file-name text-muted">
                                                   ({{ localize("Only *jpg, png, webp will be accepted") }})
                                               </p>
                                           </div>
                                       </div>
                                   </div>

                                   <div class="col-lg-12">
                                       <div class="form-group">
                                           <label for="title">{{ localize('Prompt') }} <span class="text-danger">*</span></label>
                                           <x-form.textarea
                                                   name="prompt"
                                                   id="title"
                                                   row="5"
                                                   cols="5"
                                                   placeholder="Describe your idea to generate image"></x-form.textarea>
                                       </div>
                                   </div>

                                   <div class="col-lg-3">
                                       <x-form.button class="btn btn-primary" id="frmActionBtn" type="submit">
                                           {{ localize('Generate Image') }}
                                       </x-form.button>
                                   </div>

                               </div>
                           </form>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
