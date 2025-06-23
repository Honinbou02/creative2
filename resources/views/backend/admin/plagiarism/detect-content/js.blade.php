
@php
    $series = [100, 0];
@endphp
<script src="{{ asset('assets/js/vendors/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/apex-scripts.js') }}"></script>
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
            series:@json($series),
            labels: ["{{ localize('Human Writing') }}", "{{ localize('AI Writing') }}"],

        };

        var plag = new ApexCharts(
            document.querySelector("#donutChat"),
            options
        );
        plag.render();


    $("#aiContentScan").submit(function(e) {
        e.preventDefault();

        initScrollToChatBottom();

        let formData = $('#aiContentScan').serialize();

        loading('#scanContent', 'Scaning...');
        // return;
        let callParams = {};
        callParams.url = $("form#aiContentScan").attr("action");
        callParams.type = "POST";

        callParams.data = formData;       
        $('#renderChat').html('');
        ajaxCall(callParams, function(response) {
            resetLoading('#scanContent', 'Scan content');
            if(response.response_code == 400){
                toast(response.message, 'error');
            }
            if(response.response_code == 201){
                toast(response.message);
            }

            if(response.optional){

                $('#renderChat').html(response.optional.view);
            }

        }, function(XHR, textStatus, errorThrown) {
            console.log(XHR);
            showFormError(XHR, '#aiContentScan');
            resetLoading('#scanContent', 'Scan content');
            toast(XHR.responseJSON.message, 'error');
        });

    }); 

</script>
