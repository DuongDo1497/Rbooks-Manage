<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#customer-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#importmanage-form').attr('action', '{{ route('warehouses-imports-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#importmanage-form').attr('action', '{{ route('warehouses-imports-store') }}');
        });

        $('#datepicker').datepicker({
            autoclose: true,
        });

        $('#datepicker1').datepicker({
            autoclose: true,
        });

        // Tìm sản phẩm thêm vào danh sách nhập hàng
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
                    $('#modal-product-quantity').val(1);

                    $('#modal-quantity').modal({
                        backdrop: 'static'
                    });
                }
            });
        });

        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "{{ trans('home.Bạn có chắc không?') }}",
                text: "Nội dung xóa sẽ được đưa vào thùng rác",
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

        // Thêm hàng vào phiếu nhập
        $('#modal-product-add-btn').click(function() {
            var table_row = $('<tr id='+ $('.search-code').val() +' class="content-table"></tr>');
            table_row.append($('<td class="text-center">' + $('.search-code').val() + '</td>'));
            table_row.append($('<td>' + $('#modal-product-name').val() + '</td>'));
            table_row.append($('<td class="quantity text-center"><input class="form-control" min="1" name="products[' + $('.search-code').val() + '][quantity]" type="number" value="' + $('#modal-product-quantity').val() + '"></td>'));
            table_row.append($('<td class="disc text-center"><input class="form-control" name="products[' + $('.search-code').val() + '][discount]" type="number" value="' + $('#modal-product-discount').val() + '"></td>'));
            table_row.append($('<td class="cover_price text-center"><input class="form-control" name="products[' + $('.search-code').val() + '][cover_price]" type="text" value="' + $('#modal-product-price').val() + '"></td>'));
            table_row.append($('<td class="total text-center"><input readonly class="form-control" name="products[' + $('.search-code').val() + '][total]" type="text" value="' + $('#modal-product-quantity').val() * $('#modal-product-price').val() + '"></td>'));
            table_row.append($('<td class="text-center"><button type="button" class="btn-delete" data-pid="'+  $('.search-code').val() +'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'));

            $('#empty-row').hide();

            $('#products-table-content').append(table_row);

            $('#modal-quantity').modal('hide');

            $('.search-code').empty();
            syncTotal();
        });

        syncTotal();

        // Xóa phiếu nhập hàng hàng
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

        // Hiển thị thông tin thanh toán
        function syncTotal(){
            var sum_total = 0; // tiền chưa trừ discout
            var sum_quantity = 0; // tổng số lượng
            var sum_subtotal = 0; // tổng tiền qua trừ discout
            var sum_discount = 0;
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
            });
            $('#sum_quantity').text(sum_quantity + ' {{ trans('home.Sản phẩm') }}');
            $('#sum_discount').text((sum_discount).toLocaleString('en-VN') + ' VNĐ');
            $('#sum_price').text(sum_subtotal.toLocaleString('en-VN') + ' VNĐ');
            $('#sum_total').text(sum_total.toLocaleString('en-VN') + ' VNĐ');
            $('#total').val(sum_total);
            $('#sub_total').val(sum_subtotal);
            $('#sumdis').val(sum_discount);
            $('#sum_quant').val(sum_quantity);
        }

        // Xóa sản phẩm trong phiếu xuất bán hàng
        $('#products-table-content').on('click change', '.content-table button', function(e){
            e.preventDefault();
            var data = $(this).attr('data-pid');
            swal({
                title: "Bạn có chắc không?",
                text: "Sản phẩm sẽ bị xóa khỏi đơn hàng",
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

        $('#products-table-content').on('keyup change', '.content-table', function(e){
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
            syncTotal();
        });
    });
</script>