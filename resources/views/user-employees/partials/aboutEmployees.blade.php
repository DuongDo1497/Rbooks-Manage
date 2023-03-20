<div class="about-employees">
    <div class="about about-1 clearfix">
        <div class="about-item">
            <span>Nhân viên:</span>
            <span><b>{{ Auth::user()->employee()->first()->fullname }}</b></span>
        </div>
        <div class="about-item">
            <span>Ngày làm chính thức:</span>
            <span>
                <b>
                    {{ date("d/m/Y", strtotime(Auth::user()->employee()->first()->begin_official_workday)) }}
                </b>
            </span>
        </div>
    </div>
    <div class="about about-2">
        <div class="about-item">
            <span>Chức vụ:</span>
            <span><b>{{ Auth::user()->employee()->first()->position()->first() == NULL ? "" : Auth::user()->employee()->first()->position()->first()->name }}</b></span>
        </div>
    </div>
    <div class="about about-3">
        <div class="about-item">
            <span>Phòng ban:</span>
            <span><b>{{ Auth::user()->employee()->first()->department()->first() == Null ? "" : Auth::user()->employee()->first()->department()->first()->name }}</b></span>
        </div>
    </div>
</div>
