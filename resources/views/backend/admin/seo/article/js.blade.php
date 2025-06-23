<script src="{{ asset('assets/js/vendors/apexcharts.min.js') }}"></script>

<script>
    var options1 = {
        chart: {
            height: 280,
            type: "radialBar",
        },
        series: [0],
        colors: ["#242427"],
        plotOptions: {
            radialBar: {
                startAngle: -110,
                endAngle: 110,
                track: {
                    background: '#ebebeb',
                    startAngle: -110,
                    endAngle: 110,
                },
                dataLabels: {
                    name: {
                        show: true,
                    },
                    value: {
                        fontSize: "24px",
                        show: true
                    }
                },
            }
        },
        stroke: {
            lineCap: "butt"
        },
        "labels": ["No Data"],
    };

    var chart = new ApexCharts(document.querySelector("#seoChart"), options1);

    chart.render();


    $(document).on("click", ".wpPostSeoCheckerBtn",function(){
        loading(".wpPostSeoCheckerBtn");
        resetLoading(".category_section_blade", "");
        loadingInContent(".seo_report");
        
        // Update the chart dynamically
        updateScoreChart();

        let article_id = $(".articleId").val();
        if(article_id == "" || article_id == null){
            toast("{{localize('Please select an article first')}}", 'warning');
            return;
        }
        
        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = "{{ route('admin.seo.wpPostSeoChecker', ['id' => ':id']) }}".replace(':id', article_id);
        callParams.data = { _token : "{{ csrf_token() }}" };

        ajaxCall(callParams, function(response) {
            resetLoading(".wpPostSeoCheckerBtn", "<i data-feather='target' class='icon-14 me-1'></i> {{ localize('Check SEO') }}");

            let color = getHelpfulContentAnalysisScoreColor(response.data.meter.score);
            let chartOptions = {
                "series": [response.data.meter.score],
                "colors": [color],
                "labels": [response.data.meter.status], 
                "plotOptions": {"radialBar": {"dataLabels": {"name": {"show": true}, "value": {"show": true, "color": color}}}}
            };
            updateScoreChart(chartOptions);

            $(".category_section_blade").html('').hide().html(response.data.category_section_blade).fadeIn('slow');
            $(".seo_report").html('').hide().html(response.data.seo_report).fadeIn('slow');
            
            initFeather();
        },
        function(err, type, httpStatus) {
            resetLoading(".wpPostSeoCheckerBtn", "<i data-feather='target' class='icon-14 me-1'></i> {{ localize('Check SEO') }}");
            resetLoading(".category_section_blade", "");
            resetLoading(".seo_report", "");
            // Update the chart dynamically
            updateScoreChart();

            toast(err.responseJSON.message, "error");
        });
    });


    $(document).on("click", ".articleSeoCheckerBtn", function(){
        loading(".articleSeoCheckerBtn");
        resetLoading(".meeterSectionReport", "");
        loadingInContent(".seoFeedBacks");

        let article_id = $(".articleId").val();
        if(article_id == "" || article_id == null) {
            toast("{{localize('Please select an article first')}}", 'warning');
            return;
        }

        // Update the chart dynamically
        updateScoreChart();

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = "{{ route('admin.seo.storeArticleSeoChecker', ['id' => ':id']) }}".replace(':id', article_id);
        callParams.data = { _token : "{{ csrf_token() }}" };
        ajaxCall(callParams, function(response) {
            resetLoading(".articleSeoCheckerBtn", "<i data-feather='target' class='icon-14 me-1'></i> {{ localize('Check SEO') }}");
            
            updateScoreChart(response.data.meter.score);
            let color = getSeoContentOptimizerScoreColor(response.data.meter.score);
            let chartOptions = {
                "series": [response.data.meter.score],
                "colors": [color],
                "plotOptions": {"radialBar": {"dataLabels": {"name": {"show": false}, "value": {"show": true, "color": color}}}}
            };
            updateScoreChart(chartOptions);

            $(".meeterSectionReport").html('').hide().html(response.data.meeter_blade).fadeIn('slow');
            $(".seoFeedBacks").html('').hide().html(response.data.feedBack_blade).fadeIn('slow');

            initFeather();
        },
        function(err, type, httpStatus) {
            console.log(err.responseText);

            resetLoading(".articleSeoCheckerBtn", "<i data-feather='target' class='icon-14 me-1'></i> {{ localize('Check SEO') }}");
            resetLoading(".meeterSectionReport", "");
            resetLoading(".seoFeedBacks", "");

            // Update the chart dynamically
            updateScoreChart();
        });


    });

    function updateScoreChart(options = {
            "series": [0],
            "colors": [getHelpfulContentAnalysisScoreColor(0)],
            "labels": ["No Data"], 
            "plotOptions": {"radialBar": {"dataLabels": {"name": {"show": true}, "value": {"show": true, "color": getHelpfulContentAnalysisScoreColor(0)}}}}
        }) {
        // Update the chart dynamically        
        chart.updateOptions(options);
        
    }

    function getSeoContentOptimizerScoreColor(score) {        
        // Determine the color based on the score
        if(score >= 75 && score <= 100) {
            return "#00ff00"; // Green
        } else if (score >= 51 && score <= 74) {
            return "#ff9900"; // Warning (Orange)
        } else if (score > 0 && score <= 50) {
            return "#ff0000"; // Red
        } else {
            return "#ebebeb"; // Gray
        }
    }

    function getHelpfulContentAnalysisScoreColor(score) {        
        // Determine the color based on the score
        if(score > 70 && score <= 100) {
            return "#00ff00"; // Green
        } else if (score >= 55 && score <= 70) {
            return "#ff9900"; // Warning (Orange)
        } else if (score > 0 && score <= 54) {
            return "#ff0000"; // Red
        } else {
            return "#ebebeb"; // Gray
        }
    }

</script>