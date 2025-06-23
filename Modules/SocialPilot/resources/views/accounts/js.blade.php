<script>
    'use strict';
     window.type      = "{{ @$type }}";
     if(window.type == "facebook"){
        $('.footer-form-submit-btn').removeClass('d-none');
     }else{
        $('.footer-form-submit-btn').addClass('d-none');
     }

    // load data
    function getDataList() {
        var callParams      = {};
        var url             = '{{ route("admin.accounts.index") }}';
        gFilterObj.type     = window.type;
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
    
    // filter by
    $('body').on('click', '.renderData', function(e){
        let type = $(this).data('type');
        window.type = type;

        if(type == "facebook"){
            $('.footer-form-submit-btn').removeClass('d-none');
        }else{
            $('.footer-form-submit-btn').addClass('d-none');
        }
        
        $('.new-account-btn').removeClass('d-none');
        getDataList();
    })

    // handle offcanvas for creating a resource
    $(document).on('change', '.newAccountBtn', function() {
        resetFormErrors('#addAccountForm');
        loadingInContent("#addAccountFormContainer");

        // ajax call to get the folder list/ html
        let callParams = {};
        let type = $(this).data('type');

        let formData = {
            type: type,
        }
        callParams.type     = "GET";
        callParams.url      = "{{ route('admin.accounts.create') }}";
        callParams.data     = formData;

        if (type == null || type == '') {
            return;
        }
        ajaxCall(callParams, function(result) {
            $('#addAccountFormContainer').empty().html(result.data);
            feather.replace();
        }, function(err, type, httpStatus) {
            feather.replace();
        });
    })

    // handle account type
    $(document).on("change",'#account_type', function (e) {
        e.preventDefault();
        let value   = $(this).val();
        let isPage  = value == 1 ? 1 : 0;
        if (isPage) {
            $('.page').removeClass('d-none');
            $('#page_id').prop('required', true);
            $('#group_id').prop('required', false);
            $('.group').addClass('d-none');
        } else{
            $('.page').addClass('d-none');
            $('#page_id').prop('required', false);
            $('#group_id').prop('required', true);
            $('.group').removeClass('d-none');
        }
    })

    // submit form
    $(document).on("click", "#frmActionBtn", function(e) {
        e.preventDefault();
        let callParams = {};
        let formData = $('#addAccountForm').serialize();
        callParams.type = "POST";
        callParams.url = "{{ route('admin.accounts.store') }}";
        callParams.data = formData;

        loading('#frmActionBtn', "{{ localize('Connecting...') }}");
        ajaxCall(callParams, function(result) {
            toast(result.message)
            resetLoading('#frmActionBtn', 'Connect Account');
            $('#addAccountFromSidebar').offcanvas('hide');
            getDataList();
        }, function(err, type, httpStatus) {
            showFormError(err, "#addAccountForm");
            resetLoading('#frmActionBtn', 'Connect Account');
        });

        return false;
    });

    getDataList();
</script>
