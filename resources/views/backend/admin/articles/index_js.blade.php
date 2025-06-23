<script>
    'use strict';
    // load article list
    function getDataList() {
        var callParams            = {};
        callParams.type           = "GET";
        callParams.dataType       = "html";
        gFilterObj.article_source = 1; // 1 = Article Source is WriteRap
        callParams.url            = "{{ route('admin.articles.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data           = '';

        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }
    
    getDataList();

    // search
    $('body').on('click', '#searchBtn', function(e) {
        e.preventDefault();
        loadingInTable("tbody", {
            colSpan: 7,
            prop: false,
        });

        var search                 = $('#f_search').val();
        var user_type              = $('#f_user_type :selected').val();
        var completed_step         = $('#f_is_active :selected').val();
        var is_published_wordpress = $('#f_is_published_wordpress :selected').val();

        gFilterObj.search          = search;
        gFilterObj.completed_step  = completed_step;

        if (is_published_wordpress === '0' || is_published_wordpress === '1') {
            gFilterObj.is_published_wordpress = is_published_wordpress;
        } else if (gFilterObj.hasOwnProperty('is_published_wordpress')) {
            delete gFilterObj.is_published_wordpress;
        }

        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });

    // Show Schedule post date and time when selected status is future
    $(document).on("change","#status",function (e) {
        e.preventDefault();
        let status = $(this).val();

        if (status === 'future') {
            $('.futureDate').removeClass('d-none');
        } else {
            $('.futureDate').addClass('d-none');
        }
    });

</script>
