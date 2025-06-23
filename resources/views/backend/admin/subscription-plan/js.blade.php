<script>
    'use strict';
    function getDataList() {
        var package_type = $('input[name="tt-package-radio"]:checked').val();
        var callParams = {};
        gFilterObj.package_type = package_type
        callParams.type = "GET";
        callParams.dataType = "html";
        callParams.url = "{{ route('admin.subscription-plans.index') }}" + (gFilterObj ? '?' + $.param(gFilterObj) :
            '');
        callParams.data = '';
        loadingInContent('#package-list', 'loading...');
        ajaxCall(callParams, function(result) {
            $('#package-list').empty().html(result);
            feather.replace();
        }, function onErrorData(err, type, httpStatus) {});
    }

    //getDataList();


    // handle offcanvas for adding an user
    $('body').on('click', '#addPlanOffCanvas', function() {
        $('#addPlanForm .offcanvas-title').text("{{ localize('Add Plan') }}");
        $('#newPlan').removeClass('d-none');
        $('#editPlan').html('');
        resetFormErrors('form#addPlanForm');
        resetForm('form#addPlanForm');

    })
    // handle offcanvas for adding an user
    $('body').on('click', '.subscriptionType', function() {
        getDataList();
    })

    // search


    // add Plan
    $("#addPlanForm").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#addPlanForm');
        loading('#frmActionBtn', 'Saving...');

        let id = $("#addPlanForm #id").val();
        let callParams = {};
        var formData = new FormData($("#addPlanForm")[0]);
        let package_type = $('input[name="tt-package-radio"]:checked').val();
        formData.append('package_type', package_type);

        callParams.data = formData;
        callParams.processData = false;
        callParams.contentType = false;

        callParams.type = "POST";
        callParams.url = $("form#addPlanForm").attr("action");
        callParams.data = formData;

        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', "{{localize('Create New Plan')}}");
            toast(result.message, 'success');            
            getDataList();
           $('#addPlanFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {            
            showFormError(err, '#addPlanForm');
            resetLoading('#frmActionBtn', "{{localize('Create New Plan')}}");
            toast(err.responseJSON.message, 'error');
        });

        return false;
    });
    // add Copy
    $("#addPlanCopyForm").submit(function(e) {
        e.preventDefault();

        resetFormErrors('form#addPlanCopyForm');
        loading('#frmActionCopyBtn', 'Coping...');

        let id = $("#addPlanCopyForm #id").val();
        let callParams = {};
        var formData = new FormData($("#addPlanCopyForm")[0]);
        let package_type = $('input[name="tt-package-radio"]:checked').val();
        formData.append('package_type', package_type);
        callParams.type = "POST";
        callParams.url = $("form#addPlanCopyForm").attr("action");
        callParams.data = formData;
        callParams.processData = false;
        callParams.contentType = false;

        // return;
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionCopyBtn', 'Save');
            toast(result.message) 
            getDataList();
            $('#addPlanFormSidebar').offcanvas('hide');
        }, function(err, type, httpStatus) {
            showFormError(err, '#addPlanCopyForm');
            resetLoading('#frmActionCopyBtn', 'Copy');
            toast(err.responseJSON.message, 'error');
        });

        return false;
    });

    // edit package
    $(document).on('click', '.edit-package', function() {
        let userId = parseInt($(this).data("id"));
        let actionUrl = $(this).data("update-url");
        let editActionUrl = $(this).data("url");

        $('#addPlanFormSidebar .offcanvas-title').text("{{ localize('Update Plan') }}");
        $('#addPlanFormSidebar').offcanvas('show');
        $('#newPlan').addClass('d-none');

        loadingInContent('#editPlan', 'loading...');
        
        let callParams = {};
        callParams.type = "GET";
        callParams.url = editActionUrl;
        callParams.data = "";

        ajaxCall(callParams, function(result) {
                
                $('#editPlan').html(result.data);

                feather.replace();

            },
            function(err, type, httpStatus) {
                toast(err.responseJSON.message, 'error');
            });
    });
    
    function editSidebarOpen(plan_id) {
        $('#addPlanFormSidebar .offcanvas-title').text("{{ localize('Update Plan') }}");
        $('#addPlanFormSidebar').offcanvas('show');
        $('#newPlan').addClass('d-none');

        loadPlanForEdit(plan_id);
    }

    $(document).on('click', '.tt_editable', function() {
        var name = $(this).data('name');
        var packageId = $('.package_id').val();
        let isCheckBox = $(this).is(':checkbox');
        
        if (isCheckBox == true) {
            var data = {
                package_id: packageId,
                name: name,
                value: $(this).is(':checked') ? 1 : 0,
                _token: "{{ csrf_token() }}",
            }
            updatePlan(data);
        } else {
            TT.selectedValue = $(".tt_update_text[data-name='" + name + "']")[0].innerHTML;
            $(".tt_update_text[data-name='" + name + "']").attr("contenteditable", "true")
                .focus();
        }
    });

    $(document).on('change', '.select2input', function() {
        var name = $(this).data('name');
        var packageId = $('.package_id').val();
            var data = {
                package_id: packageId,
                name: name,
                value: $(this).val(),
                _token: "{{ csrf_token() }}",
            }
        updatePlan(data);
    });


    $(document).on('focusout', '.tt_update_text', function() {
        var $this = this;
        let packageId = $('.package_id').val();
        let name      = $(this).data('name');
        let isInput   = $(this).data('type');
        let value     = isInput ? $($this).val() :$this.innerHTML;
        let _token    = "{{ csrf_token() }}"; 
        // Package-ID & Value must contain value.
        
        if(!packageId || !value) {
            if (!isInput) {
                return;
            }
        }

        const payload = {
            package_id: packageId,
            name: name,
            _token: _token,
            value: value
        }
        
        if(TT.selectedValue == value) {
            return;
        }
        
        updatePlan(payload);

        setTimeout(function() { 
            loadPlanForEdit(packageId);
        }, 500);

    });

    function loadPlanForEdit(plan_id) {
        let callParams  = {};
        callParams.type = "GET";
        callParams.url  = "{{ route('admin.subscription-plans.edit', [':id']) }}".replace(':id', plan_id);
        callParams.data = "";
        
        loadingInContent('#editPlan', 'loading...');

        ajaxCall(callParams, function(result) {            
            $('#editPlan').html(result.data);

            feather.replace();
        },
        function(err, type, httpStatus) {
            console.log(err);
        });
    }


    // unlimited balance
    $(document).on('change', '.unlimited_balance', function() {

        // allow_unlimited_speech_to_text,allow_unlimited_image, allow_unlimited_word, allow_unlimited_ai_video
        let data_name = $(this).data('name');
        let id = $('.package_id').val();
        let name = data_name.split('-', 1)[0];
        let str = name.replaceAll('_', " ");
        let _token = "{{ csrf_token() }}";
        var status = $(this).is(':checked') ? 1 : 0;

        var data = {
            name      : name,
            package_id: id,
            _token    : _token,
            value     : status
        }
        
        // words
        if (str.includes("word")) {
            if (status == true) {
                let value = $('#allow_word_text').text();
                localStorage.setItem("package-words_" + id, value);
                $('#allow_word_edit').addClass('d-none');
                $('#allow_word_text').html('Unlimited');
            } else {
                $('#allow_word_edit').removeClass('d-none');
                $('#allow_word_text').html(localStorage.getItem("package-words_" + id));
            }
            updatePlan(data);
        }

        //image
        if (str.includes("image")) {
            if (status == true) {
                let value = $('#allow_image_text').text();
                localStorage.setItem("package-image_" + id, value);
                $('#allow_image_edit').addClass('d-none');
                $('#allow_image_text').html('Unlimited');
            } else {
                $('#allow_image_edit').removeClass('d-none');
                $('#allow_image_text').html(localStorage.getItem("package-image_" + id));
            }
            updatePlan(data);
        }
        //speech to text
        if (str.includes("speech to text")) {
            if (status == true) {
                let value = $('#allow_speech_to_text_text').text();
                localStorage.setItem("package-speech_to_text_" + id, value);
                $('#allow_speech_to_text_edit').addClass('d-none');
                $('#allow_speech_to_text_text').html('Unlimited');
            } else {
                $('#allow_speech_to_text_edit').removeClass('d-none');
                $('#allow_speech_to_text_text').html(localStorage.getItem("package-speech_to_text_" + id));
            }
            updatePlan(data);
        }
        //ai_video
        if (str.includes("ai video")) {
            if (status == true) {
                let value = $('#allow_ai_video_text').text();
                localStorage.setItem("package-ai_video_" + id, value);
                $('#allow_ai_video_edit').addClass('d-none');
                $('#allow_ai_video_text').html('Unlimited');
            } else {
                $('#allow_ai_video_edit').removeClass('d-none');
                $('#allow_ai_video_text').html(localStorage.getItem("package-ai_video_" + id));
            }
            updatePlan(data);
        }
        //Text To Speech
        if (str.includes("text to speech")) {
            if (status == true) {
                let value = $('#allow_text_to_speech').text();
                localStorage.setItem("package-text_to_speech_" + id, value);
                $('#allow_text_to_speech_edit').addClass('d-none');
                $('#allow_text_to_speech').html('Unlimited');
            } else {
                $('#allow_text_to_speech_edit').removeClass('d-none');
                $('#allow_text_to_speech').html(localStorage.getItem("package-text_to_speech_" + id));
            }
            updatePlan(data);
        }

    })
    // discount status on/off

    $(document).on('change', '.allow_discount', function() {
        let package_id = $('.package_id').val();

        if ($(this).is(':checked')) {
            var status = true;
            discountActivities(package_id);
        } else {
            var status = false;
        }

        discoutShowHide(package_id, status);
    })

    // on Discount Type change
    async function handleDiscountTypeChange($this) {
        var discount_type = $($this).val();
        var packageId = $('.package_id').val();
        var data = {
            name: "discount_type",
            package_id: packageId,
            value: discount_type
        }
        updatePlan(data);
        await discountActivities(packageId, discount_type);
    }

       
    $(document).on('focusout', '.discount_amount', function() {
        var $this           = this;
        var value           = $($this).val();
        var packageId       = $('.package_id').val();
        var discount_type   = $('.discount_type').val();
        var amount          = $('.package-main-price').val();
        var discount_amount = discountAmount(discount_type, amount, value);

        $('.package-discount-price').removeClass('d-none').html('$' + amount);
        $('.package-price').html(discount_amount);
        var data = {
            name      : "discount_price",
            package_id: packageId,
            value     : discount_amount
        }
        updatePlan(data);
        var data = {
            name      : "discount",
            package_id: packageId,
            value     : value
        }
        updatePlan(data);

        var data = {
            name      : "discount_type",
            package_id: packageId,
            value     : discount_type
        }
        updatePlan(data);

    });
    // discount function
    function discoutShowHide(package_id, status) {
        var amount = $('.package-main-price').val();
        if (status == true) {
            $('#discount_option').removeClass('d-none');
            $('.package-price-edit').addClass('d-none');

        } else {

            $('#discount_option').addClass('d-none');
            $('.package-price-edit').removeClass('d-none');
            $('.package-discount-price').addClass('d-none');
            $('.package-price').html(amount);
        }

    }

    async function discountActivities(package_id, discount_type = false, amount = false, discount = false) {
        if (discount == false) {
            var discount = $('.package-discount').val();
        }
        if (discount_type == false) {
            var discount_type = $('.discount_type').val();
        }
        if (amount == false) {
            var amount = $('.package-main-price').val();
        }
        if (discount_type && amount > 0 && discount > 0) {
            var discount_amount = discountAmount(discount_type, amount, discount);
            $('.package-discount-price').removeClass('d-none').html('$' + amount);
            $('.package-price').html(discount_amount);
            var data = {
                name      : "discount_price",
                package_id: package_id,                
                value     : discount_amount
            }

            updatePlan(data);
        }


    }
    // discout amount calculate
    function discountAmount(discount_type, amount, discount) {
        var decimal = "{{ getSetting('no_of_decimals') ?? 2 }}";
        if (discount_type == 1) {
            var calcPrice = amount - discount;
            var discountPrice = calcPrice.toFixed();
        } else if (discount_type == 2) {
            var calcPrice = amount - ((amount / 100) * discount);
            var discountPrice = calcPrice.toFixed(decimal);
        } else {
            var discountPrice = amount;
        }
        if (discountPrice < 0) {
            var discountPrice = 0;
        }
        return discountPrice;
    }
    // amount set
    function setAmount(package_id, name, value) {
        if (name == 'package-price') {
            $('.package-main-price').val(value);
        }
    }

    function updatePlan(data) {

        let callParams = {};
        callParams.type = "POST";
        callParams.url = "{{ route('admin.subscription-plans.package-update') }}";
        callParams._token = "{{ csrf_token() }}";
        callParams.data = data;
        ajaxCall(callParams, function(result) {
            toast(result.message);
            getDataList();
        }, function(err, type, httpStatus) {
            toast(err.responseJSON.message, 'error');
        });
    }

    $('.subscription-templates-form').on('submit', function(e) {
        e.preventDefault();
        loading('.package-template-submit-btn', 'Saving...');
        let plan_id = $('#plan_id').val();
        let type = $('#template_type').val();
       
        let form = $(this);
        let callParams = {};
        callParams.type = "POST";
        callParams.url = "{{ route('admin.subscriptions.updateTemplates') }}";
        callParams._token = "{{ csrf_token() }}";
        callParams.data = form.serialize();

        ajaxCall(callParams, function(result) {
            toast(result.message);
            resetLoading('.package-template-submit-btn', 'Save');
            getDataList();
            $('.subscription-templates-form').offcanvas('hide');
            if(type == 'from-edit') {
                editSidebarOpen(plan_id);
            }          
        }, function(err, type, httpStatus) {
            toast(err.responseJSON.message, 'error');
        });

    })

    // show package payment modal
    function showPackagePaymentModal() {
        $('#packagePaymentModal').modal('show')
    }
    // handle package payment
    function handlePackagePayment($this) {        
        let package_type = $($this).data('package-type');
        let subscribed_package_type = $($this).data('previous-package-type');
        let check = true;
        let packageChangeCheck;
        let user_type = $($this).data('user-type') == "Customer" ? 'Customer' : 'Admin';

        let carryForward = '{{ getSetting('carry_forward ') ? 1 : 0 }}';

        if ((subscribed_package_type == "prepaid" || subscribed_package_type == "lifetime") && (
                package_type != "prepaid" && package_type != "lifetime")) {
            packageChangeCheck = confirm(
                `{{ localize('You current package ${subscribed_package_type} will be expired if you want to subscribe to ${package_type}. Do you want to continue?') }}`
            )

        }
        if (subscribed_package_type != package_type && user_type == "Customer" && carryForward == "0") {
            check = confirm(
                `{{ localize('You are changing your subscription package type to ${package_type}, your balance will be reset with new package balance. Want to continue?') }}`
            )
        }

        if (check || packageChangeCheck) {            
            let package_id = $($this).data('package-id');
            let price = parseFloat($($this).data('price'));
            $('.payment_package_id').val(package_id);

            let isLoggedIn = parseInt('{{ Auth::check() }}');
            let authUserType = 'Customer';

            if (isLoggedIn == 1) {                
                authUserType = "{{ appStatic()::USER_TYPES[user()->user_type] ?? 'Customer' }}";
                
                if (authUserType == "Customer") {                    
                    if (price > 0) {
                        showPackagePaymentModal();
                    } else {
                        $('.payment-method-form').submit();
                    }
                } else {
                    var redirectLink = "{{ 'admin.subscription-plans.index' }}";
                    $(location).prop('href', redirectLink)
                }
            } else {
                var redirectLink = "{{ 'admin.subscription-plans.index' }}";
                $(location).prop('href', redirectLink)
            }
        }
    }
            // on submit payment form

    $(document).on('click', '.oflinePayment', function(e) {
        let payment_type = $(this).data('method');
        hideShow(payment_type);
    })
    $(document).on('click', '.cancel', function(e) {
        let payment_type = 'online';
        hideShow(payment_type);
    })
    // 
    $(document).on('change', '#offline_payment_method', function(e) {
        let id = $(this).val();
        if (id) {
            $('.all-description').addClass('d-none');
            $('#description_' + id).removeClass('d-none');
        } else {
            $('.all-description').addClass('d-none');
        }


    })

        // hide show
        function hideShow(payment_type) {
            if (payment_type == 'offline') {
                $('#online_payment').addClass('d-none');
                $('#offline_payment').removeClass('d-none');
                $('#offline_payment_method').attr('required', 'required');
                $('#offline_amount').attr('required', 'required');
                $('#offline_payment_detail').attr('required', 'required');
            } else {
                $('#online_payment').removeClass('d-none');
                $('#offline_payment').addClass('d-none');
                $('#offline_payment_method').removeAttr('required');
                $('#offline_amount').removeAttr('required');
                $('#offline_payment_detail').removeAttr('required');
            }
        }
        // clear data
        function clearData() {
            $('#offline_payment_method').val('')
            $('#offline_amount').val('')
            $('#offline_payment_method').val('')
        }
</script>
