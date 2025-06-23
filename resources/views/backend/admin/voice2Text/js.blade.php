<script>
    'use strict';

    // // search
    $('body').on('click', '#searchBtn', function() {
        var search = $('#f_search').val();
        var user_type = $('#f_user_type :selected').val();
        var is_active = $('#f_is_active :selected').val();

        gFilterObj.search = search;
        gFilterObj.user_type = user_type;

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

    $("#aiVoiceToText").submit(function(e) {
        e.preventDefault();
        let callParams = {};
        loading('#generateContent', 'Generating...');
        callParams.data = new FormData(this);
        callParams.processData = false;
        callParams.contentType = false;
        callParams.url = "{{ route('admin.voice-to-text.store') }}";
        callParams.type = "POST";
        ajaxCall(callParams, function(response) {
            resetLoading('#generateContent', 'Generate Content');
            $('#name').val(response.optional.model.title);
            $('#generate_content_id').val(response.optional.model.id);
            $('.note-editable').html(response.optional.model.response);
            $('.saveChange').removeAttr('disabled');
            balanceRender("{{ appStatic()::PURPOSE_VOICE_TO_TEXT }}");
        }, function(XHR, textStatus, errorThrown) {
            resetLoading('#generateContent', 'Generate Content');
            toast(XHR.responseJSON.message, 'error');
        });

    }); // ai voice To Text

    $(document).on("click", ".saveChange", function(e) {
        e.preventDefault();
        let callParams = {};
        let id = $('#generate_content_id').val();
        let content_purpose = $('#content_purpose').val();

        let formData = {
            id: id,
            name: $('#name').val(),
            content_purpose: content_purpose,
            content: $('.note-editable').text()
        }
        console.log(formData);
        callParams.type = "POST";
        callParams.url = "{{ route('admin.generated-content.update') }}";
        callParams.data = formData;

        ajaxCall(callParams, function(result) {
            toast(result.message)

        }, function(err, type, httpStatus) {
            console.log(err);
            toast(err.responseJSON.message, 'error');
        });

        return false;
    });

    function balanceRender(type = null) {
        let callParams = {};
        callParams.type = "GET";
        callParams.url = "{{ route('admin.balance-render') }}";
        callParams.data = {
            type: type
        };
        ajaxCall(callParams, function(result) {
                $('#balance-render').html(result.data);
            },
            function(err, type, httpStatus) {
                toast(err.responseJSON.message, 'error');
            });
    }
    $(document).on('click', '.copyChat', function(e) {

        let textToCopy = $('.note-editable').text();
        let copyText = clearFormatData(textToCopy);

        if (navigator.clipboard && navigator.clipboard.writeText) {
            // Use the Clipboard API if available
            navigator.clipboard.writeText(copyText).then(function() {
                alert('Text copied to clipboard!');
            }).catch(function(err) {
                console.error('Failed to copy text: ', err);
            });
        } else {
            // Fallback for older browsers
            let tempTextarea = $('<textarea>');
            tempTextarea.val(copyText).appendTo('body').select();

            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('Fallback failed to copy text: ', err);
            }

            tempTextarea.remove();
        }
        toast('{{ localize('Content has been copied successfully') }}');
    })
</script>
