<div class="modal fade" id="modalAnswer" tabindex="-1" role="dialog">
    <form action="{{ route('answer_commentCmt') }}" enctype="multipart/form-data" method="GET">
        {{ csrf_field() }}
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">{{ trans('home.Nhập câu trả lời') }}</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body box-body">
            <input type="text" class="form-control" name="answer_cmt" value="" placeholder="{{ trans('home.Nhập câu trả lời') }}.....">
          </div>
          <div class="modal-footer box-control">
            <!-- <button type="submit" class="btn btn-primary btn-save">{{ trans('home.Lưu') }}</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('home.Thoát') }}</button> -->

            <div class="btn-group">
                <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                    <img src="{{ asset('img/icon-save.png') }}" alt="">
                    <span><b>{{ trans('home.Lưu') }}</b></span>
                </button>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>