<div class="row">
    <div class="col-12">
        <div class="card flex-column h-100">
            <div class="card h-100 flex-column">
                <div class="card-body d-flex flex-column h-100">
                    <span class="text-muted"></span>
                    <h4 class="fw-bold">{{ localize('Scan Report') }}</h4>
                    <div id="donutChat"></div>
                    <li>{{ localize('Human Writing') }} : <strong>{{ $human }}</strong> </li>
                    <li>{{ localize('AI Writing') }} : <strong>{{ $ai }}</strong></li>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <h4 class="h5">{{ localize('Total number of matching websites found by the Plagiarism API') }}</h4>
        @foreach ($results as $key => $item)
            <div class="mb-3 p-3">
                <label for="title" class="form-label"> {{ $key + 1 }} .<span
                        class="fw-bold tt-promot-number fw-bold fs-4 me-2"></span>{{ @$item->title }}<span
                        class="text-danger ms-1">*</span> </label>
                <p><a href="{{ @$item->url }}">{{ @$item->url }}</a></p>
                @foreach ($item['excerpts'] as $data)
                    <p>{!! @$data !!}</p>
                @endforeach
                <p>{{ @$item->date }}</p>

            </div>
        @endforeach
    </div>
</div>
@php
    $series = isset($human) ? [(int) number_format($human), (int) number_format($ai)] : [100, 0];
@endphp
<script>
    'use strict';
    var options = {
        chart: {
            width: 380,
            type: "donut"
        },
        dataLabels: {
            enabled: false
        },
        series: @json($series),
        labels: ["{{ localize('Human Writing') }}", "{{ localize('AI Writing') }}"],

    };

    var plag = new ApexCharts(
        document.querySelector("#donutChat"),
        options
    );
    plag.render();
</script>
