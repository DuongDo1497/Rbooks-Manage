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
        
        $('.btn-save').click(function() {
            $('#frm').submit();
        });
        
    });
    
    $(document).ready(function(){
         $('#cuserview').multiselect({
          nonSelectedText: 'Chọn danh sách',
          enableFiltering: false,
          enableCaseInsensitiveFiltering: false,
          buttonWidth:'640px'
         });
    });
   
</script>