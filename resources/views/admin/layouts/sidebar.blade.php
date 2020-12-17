<div class="side-menu">
    <div class="logo">
        <div class="main-logo"><img src="{{$setting->logo}}"></div>
    </div><!--End Logo-->
    <aside class="sidebar">
        <ul class="side-menu-links">
            <li class="@if(Request::route()->getName() == 'admin.home'){{'active'}}@endif"><a href="{{route('admin.home')}}">الرئيسية</a></li>
            <li class="@if(Request::route()->getName() == 'admin.sliders.index'){{'active'}}@endif"><a href="{{route('admin.sliders.index')}}">سليدر</a></li>
            <li class="@if(Request::route()->getName() == 'admin.addresses.index'){{'active'}}@endif"><a href="{{route('admin.addresses.index')}}">الفروع</a></li>
            <li class="sub-menu">
                <a rel="nofollow" rel="noreferrer" href="javascript:void(0);">
                    المتجر
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul>
                    <li class="@if(Request::route()->getName() == 'admin.categories.index'){{'active'}}@endif"><a href="{{route('admin.categories.index')}}">الاقسام</a></li>
                    <li class="@if(Request::route()->getName() == 'admin.products.index'){{'active'}}@endif"><a href="{{route('admin.products.index')}}">المنتجات</a></li>
                    <li class="@if(Request::route()->getName() == 'admin.orders.index'){{'active'}}@endif"><a href="{{route('admin.orders.index')}}">الطلبات</a></li>
                </ul>
            </li>

            <li class="sub-menu @if(
                Request::route()->getName() == 'admin.tips.*'
            ){{'active'}}@endif">
                <a rel="nofollow" rel="noreferrer" href="javascript:void(0);">
                    النصائح
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul>
                    <li class="@if(Request::route()->getName() == 'admin.tips.index'){{'active'}}@endif"><a href="{{route('admin.tips.index')}}">النصائح الثابتة</a></li>
                    <li class="@if(Request::route()->getName() == 'admin.tips.getLiveTip'){{'active'}}@endif"><a href="{{route('admin.tips.getLiveTip')}}">الاشعارات</a></li>
                </ul>
            </li>

            <li class="@if(Request::route()->getName() == 'admin.utilizes.index'){{'active'}}@endif"><a href="{{route('admin.utilizes.index')}}">الملابس المستعملة</a></li>
            <li class="@if(Request::route()->getName() == 'admin.posters.index'){{'active'}}@endif"><a href="{{route('admin.posters.index')}}">الاعلانات</a></li>
            <li class="@if(Request::route()->getName() == 'admin.users.index'){{'active'}}@endif"><a href="{{route('admin.users.index')}}">المستخدمين</a></li>

            <li class="sub-menu @if(
                Request::route()->getName() == 'admin.services.*'
            ){{'active'}}@endif">
                <a rel="nofollow" rel="noreferrer" href="javascript:void(0);">
                    الخدمات
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul>
                    <li class="@if(Request::route()->getName() == 'admin.services.index'){{'active'}}@endif"><a href="{{route('admin.services.index')}}">الخدمات المتاحة</a></li>
                    <li class="@if(Request::route()->getName() == 'admin.services.users'){{'active'}}@endif"><a href="{{route('admin.services.users')}}">مقدمي الخدمات</a></li>
                </ul>
            </li>


            <li class="@if(Request::route()->getName() == 'admin.abouts.index'){{'active'}}@endif"><a href="{{route('admin.abouts.index')}}">من نحن</a></li>
            <li class="@if(Request::route()->getName() == 'admin.contacts.index'){{'active'}}@endif"><a href="{{route('admin.contacts.index')}}">تواصل معنا</a></li>
            <li class="@if(Request::route()->getName() == 'admin.settings.index'){{'active'}}@endif"><a href="{{route('admin.settings.index')}}">الاعدادات</a></li>
        </ul>
    </aside>
</div>
