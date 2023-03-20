<script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/libs/dropzone.js') }}"></script>
<script>
    $(function() {
        

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif

        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "Bạn có chắc không?",
                text: "Nội dung xóa sẽ được đưa vào thùng rác! Xóa danh mục đồng nghĩa xóa các danh mục con",
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

        CKEDITOR.replace('description');

        $('#chk-continue').on('ifChecked', function() {
            $('#author-form').attr('action', '{{ route('authors-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#author-form').attr('action', '{{ route('authors-store') }}');
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

        Dropzone.options.imageDropzone = {
            paramName: 'image',
            dictDefaultMessage: 'Click hoặc kéo file vào để upload',
            maxFiles: 1,
            previewsContainer: '#upload-images-preview',
            init: function() {
                this.on('success', function(file, res) {
                    if(res.code == 1) {
                        $('#image_id').val(res.data.id);
                    } else {
                        alert(res.message);
                    }
                });
            }
        };
    });
</script>