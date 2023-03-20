<script>
    $(function() {

        /*** Lấy giá trị trong trạng thái để tạo task việc ***/
        var taskChild_id = $(this).data('id2');

        // if (detail_status != '5' || detail_status == '6' || detail_status == '7' || detail_status == '8') {
        // 	$('.box-tools button').attr('disabled', true);
        // }
        if(taskChild_id > 21){
        	$('.box-tools button').attr('disabled', true);
        	$('.dropdown-menu > li > a').css({"pointer-events":"none","cursor":"none"});
        }

        // Update Báo cáo tiến độ
        $('.btn-create').click(function(){
        	var id_taskChild = $('input[name="typereport"]').val();
            var numberPage = $('input[name="numberPage"]').val();
            var totalNumberPage = $('input[name="totalNumberPage"]').val();
        	var report = $('input[name="report"]').val();
            var note = $('input[name="note"]').val();
            	$.ajaxSetup({
    				headers: {
    					'X-CSRF-TOKEN': $('input[name="_token"]').val(),
    				}
    			});
            	// /public/rbooks-vn-management/public
            	$.ajax({
            		type: "POST",
                    url: '/taskChild-report/' + id_taskChild,
                    data: {
                        id_taskChild: id_taskChild,
                        report: report,
                        numberPage: numberPage,
                        totalNumberPage: totalNumberPage,
                        note: note,
                    },
                    success: function(data){
                    	console.log(data);
                    	location.reload();
                    },

                });

                $("#getReport").modal('hide');
        });

        // User nhận Task dc giao
        $('.btn-receive').click(function(){
            var initialization_user_id = $(this).data('id1');
            var user_id = $('input[name="user_id"]').val();
            var taskChild_id = $(this).data('id2');

            if(user_id != initialization_user_id) {
                swal({
                    title: "Công việc không phải cho bạn.",
                    text: "Vui lòng chọn đúng công việc được giao !!!",
                    icon: "warning",
                    dangerMode: true,
                });
            } else {
                $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    }
                });
                // /public/rbooks-vn-management/public
                $.ajax({
                    type: "POST",
                    url: '/taskChild-receive/' + taskChild_id,
                    data: {
                        taskChild_id: taskChild_id,
                        initialization_user_id: initialization_user_id,
                        user_id: user_id,
                    },
                    success: function(data){
                        console.log(data);
                        location.reload();
                    },
                });
            }
        });

        // User không nhận Task dc giao
        $('.btn-deny').click(function(){
            var initialization_user_id = $(this).data('id1');
            var user_id = $('input[name="user_id"]').val();
            var taskChild_id = $(this).data('id2');

            if(user_id != initialization_user_id) {
                swal({
                    title: "Công việc không phải cho bạn.",
                    text: "Vui lòng từ chối đúng công việc được giao !!!",
                    icon: "warning",
                    dangerMode: true,
                });
            } else {
                $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    }
                });
                // /public/rbooks-vn-management/public
                $.ajax({
                    type: "POST",
                    url: '/taskChild-deny/' + taskChild_id,
                    data: {
                        taskChild_id: taskChild_id,
                        initialization_user_id: initialization_user_id,
                        user_id: user_id,
                    },
                    success: function(data){
                        console.log(data);
                        location.reload();
                    },
                });
            }
        });

        // Thông báo User báo cáo sai
        $('.btn-report').click(function(){
            var initialization_user_id = $(this).data('id');
            var user_id = $('input[name="user_id"]').val();

            swal({
                title: "Có nhầm lẫn ở đâu đó.",
                text: "Vui lòng báo cáo đúng công việc được giao !!!",
                icon: "warning",
                dangerMode: true,
            });
        });

        $(document).bind(".btn-save",function(e) {
            e.preventDefault();
        });

        $('.demo').ready(function() {
            var statusTask = $('input[name="statusTask"]').val();
            var int = parseInt(statusTask);

            var project_percent = 100/9;
            var fixed = project_percent.toFixed(5);
            
            if (statusTask == "1") {
                var number_percent = fixed;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "2"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "3"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "4"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "5"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "6"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "7"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else if(statusTask == "8"){
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }else{
                var number_percent = fixed * int;
                var numberFloat = number_percent + "%";
                $('.progress_project .progress-bar').css('width', numberFloat);
            }
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

        $(".report_rate_of_progress").change(function() {
        
            var department = $("select[name='department']").select2('val');

            if(department == "1"){
                $('.report_number_page').show();
                $('.report_rate').hide();
            }else if(department == "2"){
                $('.report_number_page').show();
                $('.report_rate').hide();
            }else if(department == "3"){
                $('.report_rate').show();
                $('.report_number_page').hide();
            }
        });
    });
</script>