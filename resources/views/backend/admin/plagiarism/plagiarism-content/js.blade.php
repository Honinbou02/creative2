
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


    $("#plagiarismScanContent").submit(function(e) {
        e.preventDefault();
       

        let formData = $('#plagiarismScanContent').serialize();
        // return;
        let callParams = {};
        callParams.type = "POST";
        callParams.url =  $(this).attr("action");
        callParams.data = formData;       
        loading('#scanContent', 'Scaning...');
        $('#renderChat').html('');
        ajaxCall(callParams, function(response) {
            resetLoading('#scanContent', 'Scan content');
            if(response.response_code == 400){
                toast(response.message, 'error');
            }
            if(response.response_code == 201){
                toast(response.message);
            }
             $('#renderChat').html(response.optional.view);

            // Event Source Streaming

        }, function(XHR, textStatus, errorThrown) {
            resetLoading('#scanContent', 'Scan content');
            showFormError(XHR, '#plagiarismScanContent');
            toast(XHR.responseJSON.message, 'error');
        });

    }); // AI Writer Form Submit Closing

</script>
