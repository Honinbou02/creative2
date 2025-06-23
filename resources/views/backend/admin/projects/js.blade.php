<script>
    'use strict';
     window.folder_id = "{{ @$folder_id }}";
     window.type      = "{{ @$type }}";
    // load Template Categories
    function getDataList() {
        var callParams      = {};
        var url             = '{{ route("admin.documents.index") }}';
        gFilterObj.type     = window.type;
        gFilterObj.folder_id = window.folder_id;
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = url + (gFilterObj ? '?' + $.param(gFilterObj): '');
        callParams.data     = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        loadingInTable("tbody",{
            colSpan: 11,
            prop: false,
        });
        gFilterObj.search = search;
        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
    $('body').on('click', '.renderData', function(e){
        let type = $(this).data('type');
        window.type = type;
        getDataList();
    })

    getDataList();
</script>
