<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#debt-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#debt-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#debt-form').attr('action', '');
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

        $('#reservation').daterangepicker();

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif
    });
</script>