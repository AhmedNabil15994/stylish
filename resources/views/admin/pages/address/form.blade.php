@extends('admin.layouts.master')
@section('title')
    الفروع
@endsection

@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>الفروع</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الفروع</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <div class="widget">
            <form class="widget-content ajax-form" action="{{isset($address->id) ? route('admin.addresses.update',$address->id) : route('admin.addresses.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($address->id)
                    @method('PUT')
                @endisset

                <div class="alert alert-success hidden SuccessMessage" id=""></div>
                <div class="alert alert-danger hidden ErrorMessage" id=""></div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> الاسم{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$address->translate($locale)->name ?? null}}" placeholder=" الاسم{{$locale}}" name="{{$locale}}[name]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> العنوان{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$address->translate($locale)->location ?? null}}" placeholder=" العنوان{{$locale}}" name="{{$locale}}[location]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">خطوط الطول</label>
                            <input type="text" class="form-control" value="{{$address->lat}}" name="lat"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">دوائر العرض</label>
                            <input type="text" class="form-control" value="{{$address->lng}}" name="lng"/>
                        </div>
                    </div>
                </div>
                <div class="spacer-15"></div>
                <div class="col-sm-12 save-btn">
                    <button class="custom-btn green-bc" type="submit">حفظ</button>
                    <a href="{{route('admin.addresses.index')}}" class="btn btn-primary" type="submit">الغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
