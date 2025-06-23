<script>
    'use strict';

    // load Template Categories
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.wordpress.authorLists') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function(result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    getDataList();

    // handle offcanvas for adding an user
    $('body').on('click', '#addTagFormOffCanvas', function() {
        $('#addTagForm .offcanvas-title').text("{{ localize('Add Tag') }}");
        resetFormErrors('form#addTagForm');
        resetForm('form#addTagForm');
        $('form#addTagForm').attr('action', "{{ route('admin.tags.store') }}");
        $("form#addTagForm [name='_method']").attr('value', 'POST');
    })

    // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var is_active = $('#f_is_active :selected').val();

        gFilterObj.search = search;
        loadingInTable("#tags-list",{
            colSpan: 5,
            prop: false,
        });
        if (is_active === '0' || is_active === '1') {
            gFilterObj.is_active = is_active;
        } else if (gFilterObj.hasOwnProperty('is_active')) {
            delete gFilterObj.is_active;
        }


        if (gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });

</script>
@if(isModuleActive('WordpressBlog'))
    <script>
        $(document).on('click', '#syncAllUsersBtn', function(e) {
            e.preventDefault();
            loading('#syncAllUsersBtn', "<i data-feather='repeat'></i> <span id='syncText'>{{ localize('Authors from WordPress Syncing...') }}</span>");

            loadingInTable("#authors-list",{
                colSpan: 4,
                prop: false,
            });

            callParams      = {};
            callParams.type = "GET";
            callParams.url  = "{{route('admin.wordpress.syncAllUsers')}}";
            ajaxCall(callParams, function(result) {
                resetLoading('#syncAllUsersBtn', "<i data-feather='repeat'></i> <span id='syncText'>{{ localize('Sync Authors from WordPress') }}</span>");
                toast(result.message);
                getDataList();

                feather.replace();
            }, function(err, type, httpStatus) {
                resetLoading('#syncAllUsersBtn', "<i data-feather='repeat'></i> <span id='syncText'>{{ localize('Sync Authors from WordPress') }}</span>");
                toast(err.responseJSON.message,"error");
                feather.replace();
            });

            return false;
        });
    </script>
@endif