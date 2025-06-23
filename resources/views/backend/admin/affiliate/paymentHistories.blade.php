@extends('layouts.default')

@section('title')
    {{ localize('Affiliate Payment Histories') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection
@section("pagetitle", localize('Payment Histories'))
@section('breadcrumb')
    @php
        $breadcrumbItems = [['href' => null, 'title' => localize('Payment Histories')]];
    @endphp
    <x-common.breadcumb :items="$breadcrumbItems" />
@endsection
@section('content')
    <section class="tt-section">
        <div class="container">
            <div class="row g-3">
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
