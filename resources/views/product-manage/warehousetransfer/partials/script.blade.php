<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#warehousetransfers-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#warehousetransfers-form').attr('action', '{{ route('users-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#warehousetransfers-form').attr('action', '{{ route('users-store') }}');
        });

        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "Bạn có chắc không?",
                text: "Nội dung xóa sẽ được đưa vào thùng rác",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((value) => {
                console.log(value);
                if(value) {
                    document.forms['form-delete-'+id].submit();
                }
            });
        });

        $('#datepicker').datepicker({
            autoclose: true,
        });
        $('#warehousefrom_id').change(function(){
            var select = $('#warehousefrom_id option:selected').val();
            var affterChange = '';
            $('#warehousefrom_id option').each(function(){
                if($(this).val() != select)
                affterChange += '<option value="'+ $(this).val() +'">'+ $(this).text() +'</option>';
            })
            $('#warehouseto_id').html(affterChange);
        });

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif
    });
</script>