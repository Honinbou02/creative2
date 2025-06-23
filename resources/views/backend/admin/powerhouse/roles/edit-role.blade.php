@extends('admin.layouts.admin')

@section('top-header', localize('Roles') )


@section('top-actions')
    <a href="{{ route('admin.roles.index') }}" class="btn btn-success ms-2">
        <i class="fa fa-arrow-left me-2"></i>
        {{ localize('All Records') }}
    </a>
@endsection

@section('content')
    <div class="row g-3 mb-3">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    @if (errorSession())
                        <div class="row errorMessage">
                            <div class="col-lg-12">
                                <strong class="text-danger  w-100 p-3"><?= errorSession() ?> </strong>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.roles.update',["role"=>$role]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        @include('admin.powerhouse.roles.form-role', [
                            'button' => localize("Update"),
                            'cancelRoute' => false,
                        ])
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

@section("css")
    <link rel="stylesheet"
          type="text/css"
          href="{{ urlVersion("dashboardFiles/css/admin-custom.css") }}"
    />
@endsection


@section("js")
    <script>
        'use strict';

        $(document).on("click",".groupTitle",function (e) {
            let groupId             = $(this).attr("for");
            let inputWithAttribute  = `input[data-group-id="${groupId}"]`;

            let isGroupChecked = $(`#${groupId}`).prop("checked");

            $(inputWithAttribute).each(function() {
                $(this).prop('checked', !isGroupChecked);
            });
        });
    </script>
@endsection
