<script>
    'use strict';
    // load wordpress blog list
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        gFilterObj.article_source = 2; // 2 = WordPress Source
        callParams.url      = "{{ route('admin.wordpress.list') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    getDataList();

    // search
    $('body').on('click', '#searchBtn', function(e) {
        e.preventDefault();
        var search                 = $('#f_search').val();
        var user_type              = $('#f_user_type :selected').val();
        var completed_step         = $('#f_is_active :selected').val();
        var is_published_wordpress = $('#f_is_published_wordpress :selected').val();
        loadingInTable("tbody",{
            colSpan: 7,
            prop: false,
        });
        gFilterObj.search = search;
        gFilterObj.completed_step = completed_step;

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

    let importWordpressPostBlade = `<?= $importWordpressPostBlade ?>`;
    function wordpressPostImport(){
        $(".offcanvas-title").text("{{ localize('Import Wordpress Posts') }}");
        hideElement('.published-to-wordpress-wait');
        $('#wordpress-contents').empty().html(importWordpressPostBlade);

        initFeather();
    }

    // Import Wordpress Content
    $("#offcanvasImportWordpressContent").submit(function(e) {
        e.preventDefault();

        resetFormErrors('form#offcanvasImportWordpressContent');
        loading('#frmActionImportBtn', 'Importing...');

        let callParams         = {};

        callParams.type        = "POST";
        callParams.url         = $("form#offcanvasImportWordpressContent").attr("action");
        callParams.data        = new FormData($("#offcanvasImportWordpressContent")[0]);
        callParams.processData = false;
        callParams.contentType = false;
        
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionImportBtn', 'Import Post');
            toast(result.message);
            $('#offcanvasImportWordpressContent').offcanvas('hide');

            getDataList();
        }, function(err, type, httpStatus) {
            toast("{{ localize('Failed to import the post. Please try again later.') }}", 'error');
            showFormError(err, '#offcanvasImportWordpressContent');
            resetLoading('#frmActionImportBtn', 'Import Post');
        });

        return false;
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

    // Search Wordpress Post
    $(document).on("keypress", ".wpSearchKeyword", function (event) {
        var id = event.key || event.which || event.keyCode || 0;
        if(id == 13 || id == 'Enter'){
            findWordpressPost();
            return false;
        }
    });

    $(document).on("click", ".findWordpressPostBtn", function (e) {
        findWordpressPost();
    });

    function findWordpressPost() {
        let searchKeyword = $(".wpSearchKeyword").val();
       loading('.findWordpressPostBtn', 'Searching...');

       if(searchKeyword.length <=0){
           let errorP = `<p class="text-danger text-center m-0"> {{ localize('Please enter search keyword') }}</p>`;
           $('#wordpressSearchResult').html('').hide().html(errorP).fadeIn('slow');

           return false;
       }

        $('#wordpressSearchResult').html('');
        loadingInContent('#wordpressSearchResult');

       // Search ajax Request
        $.ajax({
            type: "GET",
            url: "{{ route('admin.wordpress.list') }}",
            data: {
                search: searchKeyword,
                searchWordpressPost : true
            },
            dataType: "html",
            success: function (data) {
                resetLoading('.findWordpressPostBtn', '<i data-feather="search" class="icon-14"></i> {{ localize("Find") }}');
                $('#wordpressSearchResult').html('').hide().html(data).fadeIn('slow');
                initFeather();
            },
            error: function (xhr) {
                resetLoading('.findWordpressPostBtn', '<i data-feather="search" class="icon-14"></i> {{ localize("Find") }}');
                $('#wordpressSearchResult').html('').hide().html(xhr.responseText).fadeIn('slow');
            }
        });
    }

</script>
