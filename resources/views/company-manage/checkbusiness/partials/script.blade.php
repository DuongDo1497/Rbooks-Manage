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


        $('.checkemployeeInYear').click(function(){

            var date_start = $('.fromdate').val();

            if (date_start == '') {
                $('.fromtime').prop('disabled', true);
                $('.to_end_box').hide();
                $('.todate').prop('disabled', true);
                $('.totime').prop('disabled', true);
            }

        });


        $('form').change(function(){

            var fromtime_disable = $(".fromtime").select2('val');
            var totime_disable = $(".totime").select2('val');

            var endOfWeek   = moment().endOf('week').toDate();
            var endOfWeek_format = moment(endOfWeek).format('DD MM YYYY');

            var date_start = $('.fromdate').val();
            var date_end = $('.todate').val();

            var from_date = moment(date_start);
            var from_format = moment(from_date).format('DD MM YYYY');
            var to_date = moment(date_end);
            var to_format = moment(to_date).format('DD MM YYYY');

            var date1 = moment(date_start);
            var date2 = moment(date_end);

            if(from_format == endOfWeek_format){
                $('.to_end_box').hide();
                $('.fromtime').prop('disabled', true);
                $('.todate').prop('disabled', true);
                $('.totime').prop('disabled', true);

                var diff = date1.diff(date1, 'day');
                var total_day = diff + 0.5;
                $('.numday').val(total_day);
            }else if (to_format == endOfWeek_format && date_start != '') {
                $('.fromtime').prop('disabled', false);
                $('.to_end_box').show();
                $('.totime').prop('disabled', true);

                var diff = date2.diff(date1, 'day');
                var total_day = diff + 0.5;
                $('.numday').val(total_day);
            }else if (date_start != '' && fromtime_disable == 'FULL' && date_end == '') {
                $('.fromtime').prop('disabled', false);
                $('.to_end_box').show();
                $('.todate').prop('disabled', false);

                var diff = date1.diff(date1, 'day');
                var total_day = diff + 1;
                $('.numday').val(total_day);
            }else if(date_start == date_end && date_end != '' && date_start != ''){
                $('.to_end_box').show();
                $('.fromtime').prop('disabled', true);
                $('.totime').prop('disabled', true);

                var diff = date1.diff(date1, 'day');
                var total_day = diff + 1;
                $('.numday').val(total_day);
            }else if(date_start == ''){
                $('.to_end_box').hide();
                $('.fromtime').prop('disabled', false);

                $('.numday').val(' ');
            }else if(fromtime_disable == 'SA'){
                $('.to_end_box').hide();
                $('.todate').prop('disabled', true);
                $('.totime').prop('disabled', true);

                var diff = date1.diff(date1, 'day');
                var total_day = diff + 0.5;
                $('.numday').val(total_day);
            }else if(fromtime_disable == 'CH' && date_end == ''){
                $('.to_end_box').show();
                $('.todate').prop('disabled', false);
                $('.totime').prop('disabled', true);
                $('.fromtime').prop('disabled', false);

                var diff = date1.diff(date1, 'day');
                var total_day = diff + 0.5;
                $('.numday').val(total_day);
            }else if(fromtime_disable == 'CH' && date_end != '' && totime_disable == 'FULL' || fromtime_disable == 'FULL' && date_end != '' && totime_disable == 'SA'){
                $('.to_end_box').show();
                $('.todate').prop('disabled', false);
                $('.totime').prop('disabled', false);
                
                var diff = date2.diff(date1, 'day');
                var total_day = diff + 0.5;
                $('.numday').val(total_day);
            }else if(fromtime_disable == 'CH' && date_end != '' && totime_disable == 'SA'){
                $('.to_end_box').show();
                $('.todate').prop('disabled', false);
                $('.totime').prop('disabled', false);
                
                var diff = date2.diff(date1, 'day');
                var total_day = diff;
                
                $('.numday').val(total_day);
            }else if(fromtime_disable == 'FULL' && date_end != '' && totime_disable == 'FULL'){
                $('.to_end_box').show();
                $('.todate').prop('disabled', false);
                $('.totime').prop('disabled', false);
                
                var diff = date2.diff(date1, 'day');
                var total_day = diff + 1;
                
                $('.numday').val(total_day);

            }
        });
        
    });
</script>