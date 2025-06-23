<script>
    var mediaRecorder;
    let audioBlob;
    var chunks = [];
    var stream_;

    var prompt_images = [];
    $(document).on('click', '#recordButton', function(e) {
        chunks = [];
        navigator.mediaDevices
            .getUserMedia({
                audio: true
            })
            .then(function(stream) {
                stream_ = stream;
                mediaRecorder = new MediaRecorder(stream);
                $('#recordButton').addClass('d-none');
                $('#stopButton').removeClass('d-none');
                var isRecord = true;
                mediaRecorder.ondataavailable = function(e) {
                    chunks.push(e.data);
                };
                mediaRecorder.start();
            })
            .catch(function(err) {
                console.log('The following error occurred: ' + err);
                toastr.warning('Audio is not allowed');
            });


        $(document).on('click', '#stopButton', function(e) {
            e.preventDefault();
            $('#recordButton').removeClass('d-none');
            $('#stopButton').addClass('d-none');
            var isRecord = false;
            mediaRecorder.onstop = function(e) {
                var blob = new Blob(chunks, {
                    type: 'audio/mp3'
                });

                var formData = new FormData();
                var fileOfBlob = new File([blob], 'audio.mp3');
                formData.append('file', fileOfBlob);

                chunks = [];

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '{{ route('admin.recordVoiceToText') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        if (data.text.length >= 5) {
                            $('#prompt').val(data.text);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        // Handle the error response
                    },
                });
            };
            mediaRecorder.stop();
            stream_
                .getTracks() // get all tracks from the MediaStream
                .forEach(track => track.stop()); // stop each of them
        });
    });
</script>