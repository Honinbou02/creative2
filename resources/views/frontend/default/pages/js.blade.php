<script>
    'use strict';

    // load Template Categories
    function getDataList() {
        gFilterObj.perPage=8;
        var callParams = {};
        callParams.type = "GET";
        callParams.dataType = "html";
        callParams.url = "{{ route('templates') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data = '';

        ajaxCall(callParams, function(result) {
            $('#template-1').addClass('active show');
            $('#renderTemplates').empty().html(result);
        }, function onErrorData(err, type, httpStatus) {});
    }

    $(() => {
        getDataList();
    });

    // search
    $('body').on('click', '.getTemplates', function() {

        var template_category_id = $(this).data('id');

        if (template_category_id) {
            gFilterObj.template_category_id = template_category_id;
        } else {
            delete gFilterObj.template_category_id;
        }

        getDataList();
    });




    $('body').on('click', '#subscribe-frontend', function(e) {
        e.preventDefault();
        resetFormErrors('form#subscribeForm');
        loading('#subscribe-frontend', 'Saving...');

        let callParams = {};

        callParams.type = "POST";
        callParams.url = $("form#subscribeForm").attr("action");
        callParams.data = $("form#subscribeForm").serialize();

        ajaxCall(callParams, function(result) {
            resetFormErrors('form#subscribeForm');
            resetLoading('#subscribe-frontend', 'Subscribe');
            toast(result.message);
        }, function(err, type, httpStatus) {
            showFormError(err, '#subscribeForm');
            resetLoading('#subscribe-frontend', 'Subscribe');
        });

        return false;
    });
    $("#contact-us-form").submit(function(e) {
        e.preventDefault();
        resetFormErrors('form#contact-us-form');
        loading('#frmActionBtn', 'Saving...');
        let callParams = {};
        callParams.type = "POST";
        callParams.url  = $("form#contact-us-form").attr("action");
        callParams.data = $("form#contact-us-form").serialize();
        ajaxCall(callParams, function(result) {
            resetLoading('#frmActionBtn', 'Get in Touch');
            toast(result.message)
        }, function(err, type, httpStatus) {
            showFormError(err, '#contact-us-form');
            resetLoading('#frmActionBtn', 'Get in Touch');
        });

        return false;
    });
</script>
