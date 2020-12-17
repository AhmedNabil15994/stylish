@extends('admin.layouts.master')
@section('title')
    الاقسام
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>الاقسام</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الاقسام</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <div class="widget">
            <form class="widget-content ajax-form" action="{{isset($category->id) ? route('admin.categories.update',$category->id) : route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($category->id)
                    @method('PUT')
                @endisset

                <div class="alert alert-success hidden SuccessMessage" id=""></div>
                <div class="alert alert-danger hidden ErrorMessage" id=""></div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> الاسم{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$category->translate($locale)->name ?? null}}" placeholder=" الاسم{{$locale}}" name="{{$locale}}[name]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="clip-upload">
                                <label for="file-input">
                                    <i class="fa fa-camera" aria-hidden="true" style="font-size: 20px;color: #1E99A8"></i>
                                    <span style="font-size: 20px; color: #1E99A8">الصوره</span>
                                </label>
                                <img src="{{$category->photo}}" class="img-responsive mr-bot-15 btn-product-image "
                                     style="cursor:pointer; height: 150px; width: 150px;">
                                <input type="file" style="display:none;" name="photo" class="btn-product-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer-15"></div>
                <div class="col-sm-12 save-btn">
                    <button class="custom-btn green-bc" type="submit">حفظ</button>
                    <a href="{{route('admin.categories.index')}}" class="btn btn-primary" type="submit">الغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
