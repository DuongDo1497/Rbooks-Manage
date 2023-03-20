<script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/libs/dropzone.js') }}"></script>
{{-- <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script> --}}
<script>
    $(function() {
        Dropzone.options.imageDropzone = {
            paramName: 'image',
            dictDefaultMessage: 'Click hoặc kéo file vào để upload',
            maxFiles: 1,
            previewsContainer: '#upload-images-preview',
            init: function() {
                this.on('success', function(file, res) {
                    console.log('ok');
                    if(res.code == 1) {
                        $('#image_id').val(res.data.id);
                    } else {
                        alert(res.message);
                    }
                });
            }
        };

        $("#choices_products").click(function(event) {
            event.preventDefault();
            var products_url = 'product/export-choose?';
            $('.check_product:checked').map((i, e) => {
                console.log(i);
                if(i === 0) {
                    products_url += "products_arr[]=" + e.value;
                } else {
                    products_url += "&products_arr[]=" + e.value;
                }
            });

            // console.log();
            window.location.href = products_url;
            // $.ajax({
            //     url: '/product/export-choose',
            //     data: {
            //         products_arr
            //     },
            //     success: (res) => {console.log(res)},
            //     error:(err) => {console.log(err)}
            // });

        });
        // $(".iCheck-helper").click(function(e){
        //     var id_chooses = [];
        //     id_chooses = $(e.target).prev().data('id');
        //     console.log(id_chooses);

        //     // $.get('{{ route('product-exportChoose', ['$id[] => id_chooses']) }}')
        // });

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

        CKEDITOR.replace('description');

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        $('.btn-save').click(function() {
            $('#author-form').submit();
        });

        $('#name').change(function() {
            $('#slug').val(ChangeToSlug($('#name').val()));
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
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            return slug;
        }

        $('.look_inside').change(function() {
            var numb = $(this)[0].files[0].size/1024/1024;
            var resultid = $(this).val().split(".");
            var gettypeup  = resultid [resultid.length-1];
            var filetype = $(this).attr('data-file_types');
            var allowedfiles = filetype.replace(/\|/g,', ');
            var filesize = 1;
            var onlist = $(this).attr('data-file_types').indexOf(gettypeup) > -1;
            var checkinputfile = $(this).attr('type');
            var numb_fix = numb.toFixed(2);

            if(onlist && numb_fix <= filesize){
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
    });
</script>