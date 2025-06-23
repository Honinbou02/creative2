<script>
    'use strict';

    // load users
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.plan-histories.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        // loadingInContent("#history-list", 'loading..');
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }
    getDataList();
    // search
    $('body').on('click', '#searchBtn', function(e) {
        e.preventDefault();
        loadingInTable("#history-list",{
            colSpan: 11,
            prop: false,
        });
        var search                 = $('#f_search').val();
        var subscription_status    = $('#f_subscription_status :selected').val();
        var subscription_plan_id   = $('#f_plan_type :selected').val();

        gFilterObj.search = search;
        gFilterObj.subscription_plan_id = subscription_plan_id;
        gFilterObj.subscription_status    = subscription_status;

        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });
</script>
