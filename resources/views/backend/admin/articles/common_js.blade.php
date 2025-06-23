<script src="{{ asset('assets/js/vendors/apexcharts.min.js') }}"></script>
<script>
    'use strict';
    // Saving Article changes content.
    $(document).on("click", ".saveChange", function(e) {
        e.preventDefault();
        saveArticleContentChanges();

        return false;
    });

    function saveArticleContentChanges() {
        loading('#saveChangeBtn', "<i data-feather='save' class='icon-14'></i> {{localize('Changes Saving...')}}");

        let title                  = $('#text-input').val();
        let id                     = $("#article_id").val();
        let topic                  = $('#contentTopic').val().trim();
        let focus_keyword          = $('#focusKeyword').val().trim();
        let keywords               = $('#contentKeywords').val().trim();
        let meta_description       = $('#contentMetaDescriptions').val().trim();

        var url             = "{{ route('admin.articles.update',":id") }}".replace(':id', id);            
        let content_purpose = 'articles';
        let formData        = {
            id     : id,
            title  : title,
            type   : 'article',
            article: $('.note-editable').html(),
            topic  : topic,
            focus_keyword : focus_keyword,
            keywords : keywords,
            meta_description : meta_description,
        }
        
        let callParams  = {};
        callParams.type = "PUT";
        callParams.url  = url;
        callParams.data = formData;

        ajaxCall(callParams, function(result) {
            resetLoading('#saveChangeBtn', "<i data-feather='save' class='icon-14'></i> {{localize('Save Changes')}}");
            toast(result.message) ;
            feather.replace();
        }, function(err, type, httpStatus) {
            resetLoading('#saveChangeBtn', "<i data-feather='save' class='icon-14'></i> {{localize('Save Changes')}}");
            toast(err.responseJSON.message);
            feather.replace();
        });

        return false;
    }

    // published to wordpress
    function publishedBlogPost(articleId, wpPostId) {
        $(".offcanvas-title").text("{{ localize('Push to WordPress') }}");
        loading("#publishedToWordpressBtn", "{{ localize('Pushing to WordPress') }}")
        loadingInContent('#published-to-wordpress-contents');

        gFilterObj.id             = articleId
        gFilterObj.wp_post_id     = wpPostId
        gFilterObj.article_source = 1; // 1 = Article Source is WriteRap

        var callParams            = {};
        callParams.type           = "GET";
        callParams.dataType       = "html";
        callParams.url            = "{{ route('admin.wordpress-posts-published.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data           = '';

        ajaxCall(callParams, function(result) {
            $('#published-to-wordpress-contents').empty().html(result);
            $("#wp_categories").select2();
            $("#wp_tags").select2();
            resetLoading("#publishedToWordpressBtn", "<i data-feather='trending-up' class='icon-14'></i> {{ localize('Push to WordPress') }}");
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    $("#offcanvasPublishedToWordpress").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#offcanvasPublishedToWordpress');
        loading('#publishToWordPressBtn', 'Syncing...');
    
        let callParams         = {};
        callParams.type        = "POST";
        callParams.url         = $("form#offcanvasPublishedToWordpress").attr("action");
        callParams.data        = new FormData($("#offcanvasPublishedToWordpress")[0]);
        callParams.processData = false;
        callParams.contentType = false;
        ajaxCall(callParams, function(result) {
            resetLoading('#publishToWordPressBtn', "<i data-feather='trending-up' class='icon-14'></i> {{ localize('Push to WordPress') }}");
            toast(result.message);
            $('#offcanvasPublishedToWordpress').offcanvas('hide');
            
            if($('.tt-table-container').length) {
                getDataList();
            } else {
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }

        }, function(err, type, httpStatus) {
            showFormError(err, '#offcanvasPublishedToWordpress');
            resetLoading('#publishToWordPressBtn', "<i data-feather='trending-up' class='icon-14'></i> {{ localize('Push to WordPress') }}");
            feather.replace();
        });

        return false;
    });

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

    $(document).on('click', '.articleSeoCheckerBtn', function(e) {
        $(".offcanvas-title").text("{{ localize('SEO Check') }}");
        resetLoading(".meeterSectionReport", "");
        loadingInContent(".seoFeedBacks");

        let article_id = $(".articleId").val();
        if(!article_id) {
            toast("{{localize('Please select an article first')}}", 'warning');
            $("#offCanvasArticleSeoChecker").offcanvas('hide');
            return;
        }

        var route = $(this).attr("href");
        if(!route) {
            toast("{{localize('Invalid request')}}", 'warning');
            setTimeout(function() {
                $("#offCanvasArticleSeoChecker").offcanvas('hide');
            }, 2000);
            return;
        }

        // Update the chart dynamically
        updateScoreChart();

        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = route;
        callParams.data = { _token : "{{ csrf_token() }}" };
        ajaxCall(callParams, function(response) {            
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

            feather.replace(); // Reinitialize feather icons
        },
        function(err, type, httpStatus) {
            console.log(err.responseText);

            resetLoading(".meeterSectionReport", "");
            resetLoading(".seoFeedBacks", "");
            // Update the chart dynamically
            updateScoreChart();
        });
    });

    $(document).on("click", ".wpPostSeoCheckerBtn",function(){
        $(".offcanvas-title").text("{{ localize('SEO Check') }}");
        resetLoading(".category_section_blade", "");
        loadingInContent(".seo_report");
        
        // Update the chart dynamically
        updateScoreChart();

        let article_id = $(".articleId").val();
        if(!article_id){
            toast("{{localize('Please select an article first')}}", 'warning');
            return;
        }
        var route = $(this).attr("href");
        if(!route) {
            toast("{{localize('Invalid request')}}", 'warning');
            setTimeout(function() {
                $("#offCanvasArticleSeoChecker").offcanvas('hide');
            }, 2000);
            return;
        }
        
        let callParams  = {};
        callParams.type = "POST";
        callParams.url  = route;
        callParams.data = { _token : "{{ csrf_token() }}" };

        ajaxCall(callParams, function(response) {
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
            resetLoading(".category_section_blade", "");
            resetLoading(".seo_report", "");
            // Update the chart dynamically
            updateScoreChart();

            toast(err.responseJSON.message, "error");
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
            return "#24c55e"; // Green
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
            return "#24c55e"; // Green
        } else if (score >= 55 && score <= 70) {
            return "#ff9900"; // Warning (Orange)
        } else if (score > 0 && score <= 54) {
            return "#ff0000"; // Red
        } else {
            return "#ebebeb"; // Gray
        }
    }

</script>
