<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.search-code').select2({
            placeholder: '{{ trans('home.Tìm kiếm sản phẩm') }}',
            ajax: {
                url: '{{ route('api-products-search') }}',
                processResults: function (data) {
                    return {
                        results: data.items
                    };
                }
            }
        }).change(function() {
            var product_id = $(this).val();

            $.ajax({
                url: '{{ route('api-products-get') }}' + '/' + product_id,
                success: function(data) {
                    var product = data.product;

                    $('#modal-product-name').val(product.name);
                    $('#modal-product-price').val(product.cover_price);
                    $('#modal-product-quantity').val(0);
                    $('#modal-product-discount').val(0);
                    //$('#model-product-ship').val(0);

                    $('#modal-product').modal({
                        backdrop: 'static'
                    });
                }
            });
        });

        $('#modal-product-add-btn').click(function() {
            var table_row = $('<tr id='+ $('.search-code').val() +' class="content-table"></tr>');
            table_row.append($('<td class="text-center">' + $('.search-code').val() + '</td>'));
            table_row.append($('<td>' + $('#modal-product-name').val() + '</td>'));
            table_row.append($('<td class="quantity"><input class="form-control" min="1" name="products[' + $('.search-code').val() + '][quantity]" type="number" value="' + $('#modal-product-quantity').val() + '"></td>'));
            table_row.append($('<td class="disc"><input class="form-control" name="products[' + $('.search-code').val() + '][discount]" type="number" value="' + $('#modal-product-discount').val() + '"></td>'));
            table_row.append($('<td class="cover_price"><input class="form-control" name="products[' + $('.search-code').val() + '][cover_price]" type="text" value="' + $('#modal-product-price').val() + '"></td>'));
            //table_row.append($('<td class="ship"><input class="form-control" type="text" value="' + $('#model-product-ship').val() + '"></td>'));
            table_row.append($('<td class="total"><input readonly class="form-control" name="products[' + $('.search-code').val() + '][total]" type="text" value="' + $('#modal-product-quantity').val() * $('#modal-product-price').val() + '"></td>'));
            table_row.append($('<td class="text-center"><button type="button" class="btn-delete" data-pid="'+  $('.search-code').val() +'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'));

            $('#empty-row').hide();

            $('#products-table-content').append(table_row);

            $('#modal-product').modal('hide');

            $('.search-code').empty();
            syncTotal();
        });

        syncTotal();
        $('#name').change(function(e){
            e.preventDefault();
            $.get('{{ route('orders-customer') }}', {key: $('#name').val()}, function(data){
                console.log(data);
            });
        });

        // Xóa phiếu bán hàng
        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "{{ trans('home.Bạn có chắc không?') }}",
                text: "{{ trans('home.Nội dung xóa sẽ được đưa vào thùng rác') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((value) => {
                if(value) {
                    document.forms['form-delete-'+id].submit();
                }
            });
        });

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif

        $('.btn-save').click(function() {
            $('#orders-form').submit();
        });

        // Hiển thị thông tin thanh toán
        function syncTotal(){

            var sum_total = 0; // tiền chưa trừ discout
            var sum_quantity = 0; // tổng số lượng
            var sum_subtotal = 0; // tổng tiền qua trừ discout
            var sum_discount = 0;
            var sum_total_ship = 0;
            var ship = 0;

            $("#products-table-content tr").each(function() {
                var value_quantity = $(this).find('.quantity input').val();
                var value_price = $(this).find('.cover_price input').val();
                var value_discount = $(this).find('.disc input').val();

                $(this).find('.total input').val((parseFloat(value_price) * parseFloat(value_quantity)) - parseFloat(value_discount / 100 * value_price * value_quantity));

                if(!isNaN(value_discount) && value_discount.length != 0) {
                    sum_discount += parseFloat(value_discount / 100 * value_price * value_quantity);
                }
                if(!isNaN(value_quantity) && value_quantity.length != 0) {
                    sum_quantity += parseFloat(value_quantity);
                }
                if(!isNaN(value_price) && value_price.length != 0) {
                    sum_subtotal += parseFloat(value_price) * parseFloat(value_quantity);
                }
                if(!isNaN(sum_total) && sum_total.length != 0) {
                    sum_total = sum_subtotal - sum_discount;
                }
                if(!isNaN(sum_total_ship) && sum_total_ship.length != 0) {
                    sum_total_ship = sum_total + ship;
                }
            });
            $('.Checked').click(function() {
                if(sum_total >= 200000){
                    $('#shipping_method').text('0 VNĐ');
                    var ship = 0;
                }
                else{
                    $('#shipping_method').text('20,000 VNĐ');
                    var ship = 20000;
                }
            });

            $('.unChecked').click(function() {
                if(sum_total >= 200000){
                    $('#shipping_method').text('0 VNĐ');
                    var ship = 0;
                }
                else{
                    $('#shipping_method').text('25,000 VNĐ');
                    var ship = 25000;
                }
            });

            $('.ten').click(function() {
                if(sum_total >= 200000){
                    $('#shipping_method').text('0 VNĐ');
                    var ship = 0;
                }
                else{
                    $('#shipping_method').text('10,000 VNĐ');
                    var ship = 10000;
                }
            });

            $('.three').click(function() {
                if(sum_total >= 200000){
                    $('#shipping_method').text('0 VNĐ');
                    var ship = 0;
                }
                else{
                    $('#shipping_method').text('30,000 VNĐ');
                    var ship = 30000;
                }
            });

            $('.forty-five').click(function() {
                if(sum_total >= 200000){
                    $('#shipping_method').text('0 VNĐ');
                    var ship = 0;
                }
                else{
                    $('#shipping_method').text('45,000 VNĐ');
                    var ship = 45000;
                }
            });

            $('.free-ship').click(function() {
                $('#shipping_method').text('0 VNĐ');
                var ship = 0;
            });

            $('#sum_quantity').text(sum_quantity + ' {{ trans('home.Sản phẩm') }}');
            $('#sum_discount').text((sum_discount).toLocaleString('en-VN') + ' VNĐ');
            $('#sumdis').val(sum_discount);
            $('#sum_price').text(sum_subtotal.toLocaleString('en-VN') + ' VNĐ');
            $('#sub_cover_price').val(sum_subtotal);
            $('#sum_total').text(sum_total.toLocaleString('en-VN') + ' VNĐ');
            $('#sumtotal').val(sum_total);
            $('#to_tal').text(sum_total.toLocaleString('en-VN') + ' VNĐ');
            $('#total').val(sum_total);
            $('#feeship').val(ship);
            $('#sum_quant').val(sum_quantity);
        }

        // Sao chép thông tin đặt hàng sang thanh toán
        $("#copy").click(function(e){
            e.preventDefault();
            if($("#name_delivery").val() != "" && $("#phone_delivery").val() && $("#city_delivery").val() && $("#district_delivery").val() && $("#address_delivery").val() && $("#email_delivery").val()){
                $("#name_billing").val($("#name_delivery").val());
                $("#phone_billing").val($("#phone_delivery").val());
                $("#city_billing").val($("#city_delivery").val());
                $("#district_billing").val($("#district_delivery").val());
                $("#address_billing").val($("#address_delivery").val());
                $("#ward_billing").val($("#ward_delivery").val());
                $("#email_billing").val($("#email_delivery").val());
            }
            else{
                swal({
                    title: "{{ trans('home.Thông báo') }}",
                    text: "{{ trans('home.Vui lòng điền đầy đủ thông tin địa chỉ giao hàng') }}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
            }
        });

        // Xóa sản phẩm trong phiếu xuất bán hàng
        $('#products-table-content').on('click change', '.content-table button', function(e){
            e.preventDefault();
            var data = $(this).attr('data-pid');
            swal({
                title: "{{ trans('home.Bạn có chắc không?') }}",
                text: "{{ trans('home.Sản phẩm sẽ bị xóa khỏi đơn hàng') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((value) => {
                if(value) {
                    $("#" + data).remove();
                    syncTotal();
                }
            });
        });

        // Kiểm tra số lượng sản phẩm trong kho trên table
        $('#products-table-content').on('keydown change', '.content-table', function(e){
            e.preventDefault();
            var id = $(this).find('td').eq(0).text();// id sản phẩm thay đổi số lượng
            var warehouse_id = $('#warehouse_id').val(); // lấy id kho hàng bán sản phẩm để get số lượng
            var quantity = $('#'+id).find('.quantity input').val(); // số lượng thay đổi
            var discount_percent = $('#'+id).find('.discount input').val(); // phần trăm giảm giá
            var price = $('#'+id).find('.cover_price input').val(); // lấy giá sách
            var discount = (discount_percent/100) * price * quantity; // tổng số tiền giảm giá
            var total = (quantity * price) - discount; // tổng giá tiền
            $('#'+id).find('.val-total').text(total.toLocaleString('en-VN') + ' VNĐ'); // hiển thị ra màn hình tổng tiền
            $('#'+id).find('.input-total').attr('value', total); // thay đổi value input

            $.get('{{ route('orders-quantity') }}', {'product': id, 'warehouse': warehouse_id }, function(data){
                if(parseInt(data) < parseInt(quantity)){
                    swal({
                            title: "Thông báo",
                            text: "Số lượng trong kho chỉ còn " + data,
                            icon: "warning",
                            danger: true,
                        })
                    .then((value) => {
                        $('#'+id).find('.quantity input').val(data);
                        $('#'+id).find('.val-total').text(Number(price * parseInt(data)).toLocaleString('en-VN') + ' VNĐ'); // set tổng tiền
                        $('#'+id).find('.input-total').attr('value', price * parseInt(data)); //set value input
                        $('#'+id).find('.discount input').val(0); //set
                        syncTotal();
                    });
                }
            });
            syncTotal();
        });

        // Kiểm tra số lượng trên MODAL
        $('#modal-product-quantity').change(function(e){
            e.preventDefault();
            var id = $('.search-code').val(); // id sản phẩm thay đổi số lượng
            var warehouse_id = $('#warehouse_id').val();
            var quantity = $('#modal-product-quantity').val();

            $.get('{{ route('orders-quantity') }}', {'product': id, 'warehouse': warehouse_id }, function(data){
                if(parseInt(data) < parseInt(quantity)){
                swal({
                        title: "Thông báo",
                        text: "Số lượng trong kho chỉ còn " + data,
                        icon: "warning",
                        danger: true,
                    })
                }
            });
        });

        $('.typeorderI').keyup(function() {
            $('#slugI').val(ChangeToSlug($('.typeorderI').val()));
        });

        $('.typeorderII').keyup(function() {
            $('#slugII').val(ChangeToSlug($('.typeorderII').val()));
        });

        $('.typeorderIII').keyup(function() {
            $('#slugIII').val(ChangeToSlug($('.typeorderIII').val()));
        });

        $('.typeorderIV').keyup(function() {
            $('#slugIV').val(ChangeToSlug($('.typeorderIV').val()));
        });

        function ChangeToSlug(text)
        {
            //Đổi chữ hoa thành chữ thường
            slug = text.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '');
            slug = slug.replace(/\-\-\-\-/gi, '');
            slug = slug.replace(/\-\-\-/gi, '');
            slug = slug.replace(/\-\-/gi, '');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            return slug;
        }

    });
</script>
