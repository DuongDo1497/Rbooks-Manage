<script>
    $(function() {
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

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif

        $('#chk-continue').on('ifChecked', function() {
            $('#warehouse-form').attr('action', '{{ route('warehouses-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#warehouse-form').attr('action', '{{ route('warehouses-store') }}');
        });

        $('.btn-save').click(function() {
            $('#warehouse-form').submit();
        });
    });
</script>