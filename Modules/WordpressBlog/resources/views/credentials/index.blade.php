@extends('layouts.default')

@section('title')
    {{ localize('Wordpress Setting') }} {{ getSetting('tab_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Wordpress Setting'))

@section('breadcrumb')
    @php
    $breadcrumbItems = [['href' => null, 'title' => 'WordPress Setting']]; @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection
@section('content')
    <section class="mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">                      
                        <div class="card-body">
                            <div class="row g-4">
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="card tt-integration-card h-100">
                                        <div class="card-body">
                                            <div class="tt-integration-card__icon mb-3">
                                                <img src="{{urlVersion('assets/img/wordpress.png')}}"
                                                    alt="image" class="img-fluid">
                                            </div>
                                            <h5>
                                                {{localize('WordPress Integration')}}
                                            </h5>

                                        </div>
                                        <div class="card-footer mt-auto bg-transparent border-0 pt-0">
                                            <div class="d-flex align-items-center flex-wrap gap-3">
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="offcanvas" data-bs-target="#addWorpressCredentialFormSidebar">
                                                    {{localize('Update Credentials')}}
                                                </button>

                                                <a href="{{ route('admin.connectWP') }}" class="btn btn-success btn-sm ">
                                                    {{localize('Test Connection')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Add Template Category start-->
    @include('wordpressblog::credentials.add')
    <!-- Add Template Category -->
@endsection
@section('js')
    @include('wordpressblog::credentials.js')
@endsection
