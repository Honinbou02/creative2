<script>

    // Load Avatar Pro Videos

    async function loadAvatarProVideos(){
        loadingInContent(".loadAvatarProVideos");
        let callParams = {};
        callParams.type     = "GET";
        callParams.url      = "{{ route('admin.avatarPro.index') }}?loadData=true";
        callParams.dataType = "html";

        loading(".loadAvatarProVideos", "Loading...");

        await ajaxCall(callParams, function(result) {
            $('.loadAvatarProVideos').html(result);
            initFeather();
        }, function onErrorData(err, type, httpStatus) {
            console.log("Error Response", err.responseJSON)
            toast(err.responseJSON.message, "error");
        });
    }

    loadAvatarProVideos();

    // handle offcanvas for creating a new video
    $('body').on('click', '#addAvatarProFrmOffCanvas', function() {
        loadAvatars();
        loadVoices();
    })

    function formatState(state) {
        if (!state.id) {
            return state.text; // For placeholder or no selection.
        }

        // Safely retrieve the data-preview_image_url attribute.
        var imageUrl = $(state.element).data('preview_image_url') || '';

        // Return the formatted state.
        var $state = $(`
            <div style="display: flex; align-items: center;">
                <div><img src="${imageUrl}" style="display: inline-block; height: 36px; width: auto;" alt="${state.id}" /></div>
                <div style="margin-left: 10px;">
                    ${state.text}
                </div>
            </div>`
        );

        return $state;
    }


    function loadAvatars(){
        loadingInContent(".loadAvatars");
        let callParams = {};
        callParams.type     = "GET";
        callParams.url      = "{{ route('admin.avatarPro.getAvatarsAndTalkingPhotos') }}";
        callParams.dataType = "JSON";

        ajaxCall(callParams, function (response) {
            // $(".loadAvatars")
            //     .css( "height", "350px" )
            //     .html(response.data);

            let options = "";
            response.data.forEach(avatar => {
                options += `<option value="${avatar.avatar_id}" data-avatar_id="${avatar.avatar_id}"  data-preview_image_url="${avatar.preview_image_url}">
                    ${avatar.avatar_name} (Gender: ${avatar.gender})
                </option>`;
            });

            // $("#avatar_id_select2").find('option').remove().end().append(options).trigger('change');
            // Append the new options
            const $select = $("#avatar_id_select2");
            $select.find('option').remove(); // Clear previous options
            $select.append(options);

            // Reinitialize Select2 to apply the templateResult
            $select.select2({
                templateResult: formatState,
                templateSelection: formatState, // Optional: If you want the selected item to show the image.
                escapeMarkup: function (markup) {
                    return markup; // Allow custom HTML to render.
                }
            });

            // Trigger a change event to update the dropdown if necessary
            $select.trigger('change');

        });
    }

    function loadVoices(){ 
        let callParams      = {};
        callParams.type     = "GET";
        callParams.url      = "{{ route('admin.avatarPro.getVoices') }}";
        callParams.dataType =  "JSON";

        ajaxCall(callParams, function (response) {
            let options = "";
            response.data.forEach(voice => {
                options += `<option value="${voice.voice_id}" data-audio="${voice.preview_audio}">
                    ${voice.name} | Lang: ${voice.language} | Gender: ${voice.gender}
                </option>`;
            });
            
            $("#voice_id").find('option').remove().end().append(options);
        });
    }


    $(document).on("click",".avatarDiv",function () {
        // Remove Active class
        $(".avatarDiv").removeClass("activeAvatar");

        // Add Active class
        $(this).addClass("activeAvatar");

        var avatar_id = $(this).attr("data-avatar_id");
        $("#avatar_id").val(avatar_id);
    });


    $(document).on("click",".playAudio",function () {
        var audio_url = $("#voice option:selected").data("audio");
        var audio     = new Audio(audio_url);
        audio.play();
    });

    // Video Status Check
    $(document).on("click", ".checkVideoStatus", function() {
        let video_id     = $(this).data("video_id");
        let id           = $(this).data("id");
        let dynamicClass = `.videoImg${id}`;

        // Add loading text to the status
        $(`.videoStatusCls${id}`).html(`<button class="btn btn-primary" type="button" >
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
        </button>`);

        let callParams      = {};

        callParams.type     = "GET";
        callParams.url      = "{{ route('admin.avatarPro.index') }}?checkVideoStatus=1&video_id=" + video_id;
        callParams.dataType = "JSON";

        ajaxCall(callParams, function (response) {

            if(response.data.generated_video_status == 'completed' || response.data.generated_video_status == 'Completed'){
                let downloadBtn = `<a href="${response.data.generated_video_url}"
                        download=""
                        class="btn btn-success ">
                        <i data-feather="download"></i>
                </a>`;

                $(`.videoBtnArea${id}`).html(downloadBtn);
            }

            $(`.videoStatusCls${id}`).text(response.data.generated_video_status);
            $(dynamicClass).attr("src", response.data.generated_thumbnail);

            initFeather();
        });
    });


    // Avatar pro Form Submit
    $(document).on("submit", "#addAvatarProForm", function(e) {
        e.preventDefault();
        let callParams = {};
        callParams.type = "POST";
        callParams.url = "{{ route('admin.avatarPro.createVideo') }}";
        callParams.data = new FormData(this);
        callParams.cache = false;
        callParams.contentType = false;
        callParams.processData = false;
        ajaxCall(callParams, function(response) {
            toast(response.message, "success");
            loadAvatarProVideos();
        }, function (XHR, textStatus, errorThrown) {
            console.log("Server Error", XHR.responseJSON);
        });
    });

</script>