<div class="top-header">
    <div class="toggle-icon"  data-toggle="tooltip" data-placement="right" title="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <ul class="top-header-links">
        <li class="profile">
            <a class="custom-btn">
                <img src="{{auth()->guard('admin')->user()->photo}}">
                {{auth()->guard('admin')->user()->name}}
            </a>
        </li>
        <li>
            <a href="{{route('admin.profile')}}">الصفحة الشخصية</a>
        </li>
        <li>
            <a href="{{route('admin.logout')}}"><i class="fa fa-power-off"></i></a>
        </li>
    </ul>
</div>