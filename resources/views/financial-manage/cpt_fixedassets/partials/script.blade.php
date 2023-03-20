<script>
    $(function() {

        $('.total-vat').attr('value', '0');

        $('form').keyup(function() {

            var novat_cost = $('input[name="novat_cost"]').val().replace(/,/g, "");
            var paided_cost_novat = $('input[name="paided_cost_novat"]').val().replace(/,/g, "");
            
            var vat = parseInt($('input[name="vat"]').val())/100;

            if(novat_cost != "" && vat != "" || paided_cost_novat != "" && vat != ""){

                var vat_cost = (parseInt(novat_cost) * vat) + parseInt(novat_cost);
                var paided_cost_vat = (parseInt(paided_cost_novat) * vat) + parseInt(paided_cost_novat);

                var remaining_cost_novat = novat_cost - paided_cost_novat;
                var remaining_cost_vat = vat_cost - paided_cost_vat ;

                $('input[name="vat_cost"]').attr('value', parseInt(vat_cost).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="paided_cost_vat"]').attr('value', parseInt(paided_cost_vat).toLocaleString('en-US', {style: "decimal"}));

                $('input[name="remaining_cost_novat"]').attr('value', parseInt(remaining_cost_novat).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="remaining_cost_vat"]').attr('value', parseInt(remaining_cost_vat).toLocaleString('en-US', {style: "decimal"}));
                
            }else if(novat_cost != "" && vat == 0 || paided_cost_novat != "" && vat == 0){
                
                var vat_cost = (parseInt(novat_cost) * 0) + parseInt(novat_cost);
                var paided_cost_vat = (parseInt(paided_cost_novat) * 0) + parseInt(paided_cost_novat);

                var remaining_cost_novat = novat_cost - paided_cost_novat;
                var remaining_cost_vat = vat_cost - paided_cost_vat ;

                $('input[name="vat_cost"]').attr('value', parseInt(vat_cost).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="paided_cost_vat"]').attr('value', parseInt(paided_cost_vat).toLocaleString('en-US', {style: "decimal"}));

                $('input[name="remaining_cost_novat"]').attr('value', parseInt(remaining_cost_novat).toLocaleString('en-US', {style: "decimal"}));
                $('input[name="remaining_cost_vat"]').attr('value', parseInt(remaining_cost_vat).toLocaleString('en-US', {style: "decimal"}));
                
            }

        });

        $('#getFormAdd').keyup(function() {

            var paided_cost_novat = $('input[name="paided_cost_novat"]').val().replace(/,/g, "");
            var paided_cost_vat = $('input[name="paided_cost_vat"]').val().replace(/,/g, "");

            var number_vat = parseInt($('div[data-vat="number_vat"]').text())/100;

            if (paided_cost_novat != "" && $('div[data-vat="number_vat"]').text() != "") {
                var paided_cost_vat = (parseInt(paided_cost_novat) * number_vat) + parseInt(paided_cost_novat);

                $('input[name="paided_cost_vat"]').attr('value', parseInt(paided_cost_vat).toLocaleString('en-US', {style: "decimal"}));
            } else if($('div[data-vat="number_vat"]').text() == ""){
                var paided_cost_vat = (parseInt(paided_cost_novat) * 0) + parseInt(paided_cost_novat);

                $('input[name="paided_cost_vat"]').attr('value', parseInt(paided_cost_vat).toLocaleString('en-US', {style: "decimal"}));

                
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
                    $('.fileName span').text("");
                    confirm('Added file is too big \(' + numb_fix + ' MB\) - max file size '+ filesize +' MB');
                } else if(numb_fix < filesize && !onlist || !onlist) {
                    $(this).val('');
                    $('.fileName span').text("");
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

        var type_cost = $('div[data-name="type-cost"]').text();

        // if(type_cost == "Chưa chi" || type_cost == "Đã chi"){
        //     $('#detail-payment').hide();
        // }else{
        //     $('#detail-payment').show();
        // }
        
    });
</script>