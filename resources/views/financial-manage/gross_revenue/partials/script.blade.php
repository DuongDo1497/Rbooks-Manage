<script>
    $(function() {

        $('.total-vat').attr('value', '0');

        $('#information').keyup(function() {

            var notvat_revenue = $('input[name="notvat_revenue"]').val().replace(/,/g, "");
            var dathu_notvat = $('input[name="dathu_notvat"]').val().replace(/,/g, "");

            var vat = parseInt($('input[name="vat"]').val())/100;

            if(notvat_revenue != "" && vat != "" || dathu_notvat != "" && vat != ""){

                var vat_revenue = (parseInt(notvat_revenue) * vat) + parseInt(notvat_revenue);
                var dathu_vat = (parseInt(dathu_notvat) * vat) + parseInt(dathu_notvat);

                var conlai_notvat = notvat_revenue - dathu_notvat;
                var conlai_vat = vat_revenue - dathu_vat ;

                $('input[name="vat_revenue"]').attr('value', parseInt(vat_revenue).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="dathu_vat"]').attr('value', parseInt(dathu_vat).toLocaleString('en-US', {style: "decimal"}));

                $('input[name="conlai_notvat"]').attr('value', parseInt(conlai_notvat).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="conlai_vat"]').attr('value', parseInt(conlai_vat).toLocaleString('en-US', {style: "decimal"}));

            }else if(vat == 0){

                var vat_revenue = (parseInt(notvat_revenue) * 0) + parseInt(notvat_revenue);
                var dathu_vat = (parseInt(dathu_notvat) * 0) + parseInt(dathu_notvat);

                var conlai_notvat = notvat_revenue - dathu_notvat;
                var conlai_vat = vat_revenue - dathu_vat ;

                $('input[name="vat_revenue"]').attr('value', parseInt(vat_revenue).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="dathu_vat"]').attr('value', parseInt(dathu_vat).toLocaleString('en-US', {style: "decimal"}));

                $('input[name="conlai_notvat"]').attr('value', parseInt(conlai_notvat).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="conlai_vat"]').attr('value', parseInt(conlai_vat).toLocaleString('en-US', {style: "decimal"}));

            }

        });

        $('#getFormAdd').keyup(function() {

            var dathu_notvat = $('input[name="dathu_notvat"]').val().replace(/,/g, "");
            var dathu_vat = $('input[name="dathu_vat"]').val().replace(/,/g, "");

            var number_vat = parseInt($('div[data-vat="number_vat"]').text())/100;

            if (dathu_notvat != "" && $('div[data-vat="number_vat"]').text() != "") {
                var dathu_vat = (parseInt(dathu_notvat) * number_vat) + parseInt(dathu_notvat);

                $('input[name="dathu_vat"]').attr('value', parseInt(dathu_vat).toLocaleString('en-US', {style: "decimal"}));
            } else if($('div[data-vat="number_vat"]').text() == ""){
                var dathu_vat = (parseInt(dathu_notvat) * 0) + parseInt(dathu_notvat);

                $('input[name="dathu_vat"]').attr('value', parseInt(dathu_vat).toLocaleString('en-US', {style: "decimal"}));

            }

        });


        $('.file_record_add').change(function() {
            var numb = $(this)[0].files[0].size/1024/1024;
            var resultid = $(this).val().split(".");
            var gettypeup  = resultid [resultid.length-1];
            var filetype = $(this).attr('data-file_types');
            var allowedfiles = filetype.replace(/\|/g,', ');
            var filesize = 1.5;
            var onlist = $(this).attr('data-file_types').indexOf(gettypeup) > -1;
            var checkinputfile = $(this).attr('type');
            var numb_fix = numb.toFixed(2);
            var fileName = $(this).val().split( "\\" ).pop();



            if(onlist && numb_fix <= filesize){
                $('.fileName span').text(fileName);
                confirm('Upload file successful');
            } else {
                if(numb_fix >= filesize && onlist){
                    $(this).val('');
                    confirm('Added file is too big \(' + numb_fix + ' MB\) - max file size '+ filesize +' MB');
                } else if(numb_fix < filesize && !onlist || !onlist) {
                    $(this).val('');
                    confirm('An not allowed file format has been added \('+ gettypeup +') - allowed formats: ' + allowedfiles);
                }
            }
        });

        $('.total-vat').on('input', function () {
            var value = this.value.replace(/,/g, "");
            if (isNaN(value)) {
                value = value.length > 1 ? value.slice(0, -1) : 0
            } else if (value.length === 0) {
                value = 0;
            }
            this.value = parseInt(value).toLocaleString('en-US', {style: "decimal"});
        });


        var type_revenue = $('div[data-name="status"]').text();

        if(type_cost == "Chưa thu" || type_cost == "Đã thu"){
            $('#detail-payment').hide();
        }else{
            $('#detail-payment').show();
        }
    });
</script>
