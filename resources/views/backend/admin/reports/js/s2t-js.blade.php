<script>
    "use strict";
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.reports.s2t') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    $(document).on('click', '#searchBtn', function() {
        var date_range = $('#date_range').val();
        var user_id = $('#user_id :selected').val();

        gFilterObj.date_range  = date_range;
        gFilterObj.user_id     = user_id;
        loadingInTable("tbody",{
            colSpan: 5,
            prop: false,
        });

        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
    getDataList();
</script>