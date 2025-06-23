@extends('layouts.default')

@section('title')
    {{ localize('Affiliate Withdraw Requests') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section("pagetitle", localize('Withdraw Requests'))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Withdraw Requests')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection

@section('content')
    <section class="tt-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 table-responsive" id="section-1">
                        @include('backend.admin.affiliate.inc.paymentHistoryTable', [
                            'paymentHistories' => $paymentHistories,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
