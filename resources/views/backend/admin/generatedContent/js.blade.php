<script>
    "use strict";
    $(document).on("click", ".saveChange", function(e) {
        e.preventDefault();
        let callParams = {};
        let id = $('#content_id').val();
        let formData = {
            id: id,
            name: $('#title').val(),
            content: $('.note-editable').text()
        }
        callParams.type = "POST";
        callParams.url = "{{ route('admin.generated-content.update') }}";
        callParams.data = formData;

        loading('#saveChangeBtn', 'Saving...');
        ajaxCall(callParams, function(result) {
            toast(result.message)
            resetLoading('#saveChangeBtn', 'Save Change');
        }, function(err, type, httpStatus) {
            console.log(err);
            resetLoading('#saveChangeBtn', 'Save Change');
        });

        return false;
    });
</script>