<script>
    "use strict";

    // handle offcanvas for creating a new video
    $(document).on('click', '.move_to_folder_btn', function() {
        loadingInContent("#moveToFolderContainer");

        // ajax call to get the folder list/ html
        let callParams = {};
        let id = $('#content_id').val();

        let formData = {
            id: id,
        }
        callParams.type     = "POST";
        callParams.url      = "{{ route('admin.projects.move-to-folder-content') }}";
        callParams.data     = formData;
        callParams.dataType = 'html';

        if (id == null || id == '') {
            return;
        }
        ajaxCall(callParams, function(result) {
            $('#moveToFolderContainer').empty().html(result);
            feather.replace();
        }, function(err, type, httpStatus) {
            console.log(err);
            feather.replace();
        });
        
    })

    $(document).on("click", ".moveToFolder", function(e) {
        e.preventDefault();
        let callParams = {};
        let id = $('#content_id').val();
        let folder_id = $('#folder_id').val();
        let formData = {
            id: id,
            folder_id: folder_id,
        }
        callParams.type = "POST";
        callParams.url = "{{ route('admin.projects.move-to-folder') }}";
        callParams.data = formData;

        loading('#moveToFolderBtn', 'Saving...');
        ajaxCall(callParams, function(result) {
            toast(result.message)
            resetLoading('#moveToFolderBtn', 'Save Change');
        }, function(err, type, httpStatus) {
            console.log(err);
            resetLoading('#moveToFolderBtn', 'Save Change');
        });

        return false;
    });
</script>