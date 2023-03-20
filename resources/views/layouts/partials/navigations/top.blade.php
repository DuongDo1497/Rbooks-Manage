<ul class="nav navbar-nav">
    <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fas fa-bell"></i>
            <span class="label label-warning">0</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">{{ trans('home.Bạn có') }} 0 {{ trans('home.thông báo') }}</li>
            <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#getBirthday">
                            <i class="fa fa-birthday-cake"></i> {{ trans('home.Có') }} 0 {{ trans('home.sinh nhật trong tháng') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#getCheckEmployee">
                            <i class="fa fa-check-circle"></i> {{ trans('home.Có') }} 0 {{ trans('home.nhân sự nghỉ phép hôm nay và ngày mai') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#getCheckBusiness">
                            <i class="fa fa-check-circle"></i> {{ trans('home.Có') }} 0 {{ trans('home.nhân sự công tác hôm nay và ngày mai') }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('dist/img/icon-rb.jpg') }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                <p>
                    {{ Auth::user()->name }}
                    <small>Administrator</small>
                </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="{{ route('users-detail', ['id' => Auth::user()->id ]) }}" class="btn btn-default btn-flat">{{ trans('home.Thông tin') }}</a>
                </div>
                <div class="pull-right">
                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                        onclick="
                            event.preventDefault();
                            document.getElementById('logout-form').submit();
                        "> {{ trans('home.Đăng xuất') }}</i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </li>
</ul>