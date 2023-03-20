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
</script>
<script type="text/javascript"> 
function checkView(chkbox) {
    document.all["checkall"].value = chkbox.substring(0,1);
    document.all["checkvalue"].value = chkbox.substring(2);    
    document.all["frm"].submit();  
} 
</script>