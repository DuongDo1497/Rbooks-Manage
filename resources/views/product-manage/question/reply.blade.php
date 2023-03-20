<div class="modal fade" id="modalAnswer" tabindex="-1" role="dialog">
    <form action="{{ route('answer') }}" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #24249a; padding: 5px;">
            <h3 style="color: #fff; margin: 5px 0;">{{ trans('home.Nhập câu trả lời') }}</h3>
          </div>
          <div class="modal-body">
            <input type="text" class="form-control" name="admin_answer" value="" placeholder="{{ trans('home.Nhập câu trả lời') }}.....">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-save">Lưu</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
          </div>
        </div>
      </div>
    </form>
</div>