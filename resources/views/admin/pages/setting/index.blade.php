@extends('admin.layouts.master')
@section('title')
    الاعدادات
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>الاعدادات</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الاعدادات</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>

        <div class="widget">
            <form class="widget-content ajax-form" action="{{route('admin.settings.update',$setting->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="clip-upload">
                                <label for="file-input">
                                    <i class="fa fa-camera" aria-hidden="true" style="font-size: 20px;color: #1E99A8"></i>
                                    <span style="font-size: 20px; color: #1E99A8">اللوجو</span>
                                </label>
                                <img src="{{$setting->logo}}" class="img-responsive mr-bot-15 btn-product-image "
                                     style="cursor:pointer; height: 150px; width: 150px;">
                                <input type="file" style="display:none;" name="logo" class="btn-product-image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="clip-upload">
                                <label for="file-input">
                                    <i class="fa fa-camera" aria-hidden="true" style="font-size: 20px;color: #1E99A8"></i>
                                    <span style="font-size: 20px; color: #1E99A8">الايقون</span>
                                </label>
                                <img src="{{$setting->icon ? :'http://via.placeholder.com/32x32'}}" class="img-responsive mr-bot-15 btn-product-image "
                                     style="cursor:pointer; height: 32px; width: 32px;">
                                <input type="file" style="display:none;" name="icon" class="btn-product-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> الاسم{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$setting->translate($locale)->name ?? null}}" placeholder=" الاسم{{$locale}}" name="{{$locale}}[name]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> الهاتف الاساسي{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$setting->translate($locale)->phone1 ?? null}}" placeholder=" الهاتف الاساسي{{$locale}}" name="{{$locale}}[phone1]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> الهاتف الثاني{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$setting->translate($locale)->phone2 ?? null}}" placeholder=" الهاتف الثاني{{$locale}}" name="{{$locale}}[phone2]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> العنوان{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$setting->translate($locale)->address ?? null}}" placeholder=" العنوان{{$locale}}" name="{{$locale}}[address]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>البريد الالكترونى الاساسي</label>
                            <input class="form-control" type="email" value="{{$setting->email1}}" name="email1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>البريد الالكترونى الثاني</label>
                            <input class="form-control" type="email" value="{{$setting->email2}}" name="email2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>لينك تطبيق الاندرويد</label>
                            <input class="form-control" type="text" value="{{$setting->android}}" name="android">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>لينك تطبيق الايفون</label>
                            <input class="form-control" type="text" value="{{$setting->ios}}" name="ios">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>لينك تطبيق الويندوز</label>
                            <input class="form-control" type="text" value="{{$setting->windows}}" name="windows">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>لينك الفيسبوك</label>
                            <input class="form-control" type="text" value="{{$setting->facebook}}" name="facebook">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>لينك التويتر</label>
                            <input class="form-control" type="text" value="{{$setting->twitter}}" name="twitter">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>لينك اليوتيوب</label>
                            <input class="form-control" type="text" value="{{$setting->youtube}}" name="youtube">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>لينك الانستجرام</label>
                            <input class="form-control" type="text" value="{{$setting->instagram}}" name="instagram">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>لينك الخريطة</label>
                            <textarea class="form-control" name="map">{{$setting->map}}</textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="alert alert-success hidden SuccessMessage" id=""></div>
                    <div class="alert alert-danger hidden ErrorMessage" id=""></div>
                </div>
                <div class="spacer-15"></div>
                <div class="col-sm-12 save-btn">
                    <button class="custom-btn green-bc" type="submit">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
