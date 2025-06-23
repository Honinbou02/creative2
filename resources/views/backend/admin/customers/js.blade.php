<script>
    'use strict';

    // load users
    function getDataList() {
        var callParams      = {};
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('admin.customers.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';
        ajaxCall(callParams, function (result) {
            $('tbody').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    // handle offcanvas for adding an user
    $('body').on('click', '#addCustomerBtnForOffCanvas', function(){
        $('#addCustomerFrm .offcanvas-title').text("{{ localize('Add New Customer') }}");
        resetFormErrors('form#addCustomerFrm');
        resetForm('form#addCustomerFrm');
        showElement('.password_wrapper');
        $('form#addCustomerFrm').attr('action', "{{ route('admin.customers.store') }}");
        $('form#addCustomerFrm input:hidden[name=_method]').val('POST');
    })

    // search
    $('body').on('click', '#searchBtn', function(e){
        e.preventDefault();
        var search               = $('#f_search').val();
        var is_active            = $('#f_is_active :selected').val();
        var subscription_plan_id = $('#f_plan :selected').val();
        loadingInTable("tbody",{
            colSpan: 11,
            prop: false,
        });
        gFilterObj.search    = search;
        gFilterObj.subscription_plan_id = subscription_plan_id;

        if(is_active === '0' || is_active === '1') {
            gFilterObj.is_active = is_active;
        } else if(gFilterObj.hasOwnProperty('is_active')) {
            delete gFilterObj.is_active;
        }

        if(gFilterObj.hasOwnProperty('page')) {
            delete gFilterObj.page;
        }

        getDataList();
    });

    // add user
    $("#addCustomerFrm").submit(function(e) {
        e.preventDefault();

        resetFormErrors('form#addCustomerFrm');
        loading('#addUserBtn', 'Saving...');

        let id = $("#addCustomerFrm #id").val();

        var callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("form#addCustomerFrm").attr("action");
        callParams.data = $('#addCustomerFrm').serialize();

        ajaxCall(callParams, function (result) {
          
            resetLoading('#addUserBtn', 'Save');
            showSuccess(result.message);
            if(!id) { // only for save
                resetForm('form#addCustomerFrm');
            }
            getDataList();
            $('#addCustomerSideBar').offcanvas('hide');
        }, function (err, type, httpStatus) {
            resetLoading('#addUserBtn', 'Save');
            showFormError(err, '#addCustomerFrm');
            resetLoading('#addUserBtn', 'Save');
        });

        return false;
    });

    // edit user
    $('body').on('click', '.editIcon', function(){
        let userId = parseInt($(this).data("id"));
        let actionUrl = $(this).data('url');
        let updateUrl = $(this).data('update-url');
        $('#addCustomerFrm .offcanvas-title').text("{{ localize('Update Customer') }}");
        $('#addCustomerSideBar').offcanvas('show');
        resetForm('form#addCustomerFrm');
        resetFormErrors('form#addCustomerFrm');
        hideElement('.password_wrapper');
        $('.selected-file').html('');
        $('form#addCustomerFrm').attr('action', updateUrl);
        $("form#addCustomerFrm [name='_method']").attr('value', 'PUT');

        var callParams  = {};
        callParams.type = "GET";
        callParams.url  = actionUrl;
        callParams.data = "";
        loadingInContent('#loader', 'loading...');
        hideElement('.offcanvas-body');
        ajaxCall(callParams, function (result) {
            resetLoading('#loader', '');
            showElement('.offcanvas-body');
            if(result.data) {
                let user = result.data;
                $('#addCustomerFrm #id').val(user.id);
                $('#addCustomerFrm #name').val(user.name);
                $('#addCustomerFrm #email').val(user.email);
                $('#addCustomerFrm #user_type').val(user.user_type).change();
                $('#addCustomerFrm #mobile_no').val(user.mobile_no);
                $('#addCustomerFrm #avatar').val(user.avatar);
                $('#addCustomerFrm #is_active').val(user.is_active).change();
                if(user.avatar){
                    getChosenFilesCount();
                    showSelectedFilePreviewOnLoad();
                }
            }
        }, function (err, type, httpStatus) {

        });

    });

    // change user's status
    $('body').on('click', '.changeCustomerStatus', function(){
        let userId = parseInt($(this).data("id"));
        let status = parseInt($(this).data("status"));

        swConfirm({
            title: "Do you want to change the status?",
            confirmButtonText: "Yes",
            showDenyButton: true,
        }, (result) => {
            if (result.isConfirmed) {
                var callParams  = {};
                callParams.type = "POST";
                callParams.url  = "admin/update-admin-status/"+userId;
                callParams.data = {
                    id: userId,
                    modelName: "user",
                    is_active: status ? 0 : 1,
                    _token : "{{ csrf_token() }}"
                };
                ajaxCall(callParams, function (result) {
                    toast(result.message);
                    getDataList();
                }, function (err, type, httpStatus) {
                    showFormError(err, '#addCustomerFrm');
                });
            }
        });
    });

    // delete user
    $('body').on('click', '.deleteCustomer', function(){
        let userId = parseInt($(this).data("id"));

        let actionUrl = $(this).data('url');
        swConfirm({
            title: "Do you want to delete this user?",
            confirmButtonText: "Yes",
            showDenyButton: true,
        }, (result) => {
            if (result.isConfirmed) {
                var callParams  = {};
                callParams.type = "POST";
                callParams.url  = actionUrl;
                callParams.data = {
                    id: userId,
                    _method:"DELETE",
                    _token : "{{ csrf_token() }}"
                };
                ajaxCall(callParams, function (result) {
                    toast(result.message);
                    getDataList();
                }, function (err, type, httpStatus) {
                    showFormError(err, '#addCustomerFrm');
                });
            }
        });
    });
    var offcanvasBottom = document.getElementById('offcanvasBottom')
    var secondoffcanvas = document.getElementById('addCustomerSideBar')

    offcanvasBottom.addEventListener('hidden.bs.offcanvas', function() {
        var bsOffcanvas2 = new bootstrap.Offcanvas(secondoffcanvas)
        bsOffcanvas2.show()
    })
    getDataList();

    $('body').on('change', '#assign_plan',function(e){
        if ($(this).is(':checked')) {
            $('#subscription-plan-div').removeClass('d-none');
        }else{
            $('#subscription-plan-div').addClass('d-none');
        }
    })
    $('body').on('click', '.is_paid',function(e){
        let is_paid = $('input[name="is_paid"]:checked').val();
        if (is_paid ==='free') {
            $('#payment-option').addClass('d-none');
        }else{
            $('#payment-option').removeClass('d-none');
        }
    })

    $('body').on('change', '.subscriptionPlanOption',function(e){
        e.preventDefault();
        let id = $(this).val();
        let url = "{{ route('admin.subscription-plans.get-price', [':id']) }}";
            url = url.replace(':id', id);
        var callParams  = {};
        callParams.type = "GET";
        callParams.url  = url;
        callParams.data = "";

        ajaxCall(callParams, function (result) {
            if(result.data.price){
                $('#payment_amount').val(result.data.price);
            }else{
                $('#payment_amount').val(0);
            }
        }, function onErrorData(err, type, httpStatus) {});
    })

     // assign package
     $('body').on('click', '.assignPackage', function(){
        loadingInContent("#assignPackageContainer"); 
        // ajax call to get the folder list/ html
        let userId = parseInt($(this).data("id"));
        let callParams = {};  
        let formData = {
            id: userId,
        }
        callParams.type     = "POST";
        callParams.url      = "{{ route('admin.customers.assign-package') }}";
        callParams.data     = formData;
        callParams.dataType = '';

        if (id == null || id == '') {
            return;
        }
        ajaxCall(callParams, function(result) {            
            $('#assignPackageContainer').empty().html(result.data);
            feather.replace();
        }, function(err, type, httpStatus) {
            feather.replace();
        });
    });
    $('body').on('change', '#payment_method', function(){
        let payment_method = $(this).find(':selected').data('gateway');
        if(payment_method == '{{appStatic()::OFFLINE_PAYMENT_METHOD }}'){
            $('.offline-wrapper').removeClass('d-none');
            $('#assign_offline_payment_method').prop('required', 'true');
        }else{
            $('.offline-wrapper').addClass('d-none');
            $('#assign_offline_payment_method').prop('required', 'false');
        }
        
    });

    $('body').on('click', '.is_paid_assign_package',function(e){
        let is_paid_assign_package = $('input[name="is_paid_assign_package"]:checked').val();
        if (is_paid_assign_package ==='free') {
            $('#assign-payment-option').addClass('d-none');
        }else{
            $('#assign-payment-option').removeClass('d-none');
        }
    })

    $("#assignPackageFrm").submit(function(e) {
        e.preventDefault();

        resetFormErrors('form#assignPackageFrm');
        loading('#assignPackageBtn', '{{localize('Assigning...')}}');

        var callParams  = {};
        callParams.type = "POST";
        callParams.url  = $("#assignPackageFrm").attr("action");
        callParams.data = $('#assignPackageFrm').serialize();

        ajaxCall(callParams, function (result) {
            
            resetLoading('#assignPackageBtn', '{{ localize('Assign Package') }}');
            showSuccess(result.message);
         
            getDataList();
            // $('#assignPackageSideBar').offcanvas('hide');
        }, function (err, type, httpStatus) {
            resetLoading('#assignPackageBtn', '{{ localize('Assign Package') }}');
            showFormError(err, '#assignPackageFrm');
        });

        return false;
    });
</script>
