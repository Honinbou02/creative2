<script>
    $(document).on('click', '.planType', function() {
        let type            = $(this).data('type');
        var callParams      = {};
        gFilterObj.type     = type;
        callParams.type     = "GET";
        callParams.dataType = "html";
        callParams.url      = "{{ route('plans') }}" + (gFilterObj ? '?' + $.param(gFilterObj) : '');
        callParams.data     = '';

        ajaxCall(callParams, function(result) {
            $('#price-1').addClass('active show');
            $('#plan-list').empty().html(result);
        }, function onErrorData(err, type, httpStatus) {});
    });
</script>