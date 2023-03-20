<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#users-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#users-form').attr('action', '{{ route('users-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#users-form').attr('action', '{{ route('users-store') }}');
        });

        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            if(confirm('Bạn có muốn xóa không?')){
                document.forms['form-delete-'+ id].submit();
            }
        });
    });
</script>
<script type="text/javascript">
        $(function () {
            param = {   format: "dd/mm/yyyy",
                        autoclose: true,
                        daysOfWeekHighlighted: "0,6",
                        todayHighlight: true,
                        todayBtn: "linked",
                        language: "vi",
                    };
            $('#begin_at').datepicker(param);
            $('#finish_at').datepicker(param);
        });
</script>