<script>
    'use strict';
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
