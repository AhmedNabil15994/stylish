@extends('admin.layouts.master')
@section('title')
    {{$user->name}}
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>الصفحه الشخصية</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الصفحه الشخصية</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <div>
            <div class="alert alert-success hidden SuccessMessage" id=""></div>
            <div class="alert alert-danger hidden ErrorMessage" id=""></div>
        </div>
        <div class="spacer-15"></div>
        <div class="widget">
            <form class="widget-content ajax-form" action="{{route('admin.profile.update',$user->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>الاسم</label>
                            <input class="form-control" type="text" value="{{$user->name}}" name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>رقم الهاتف</label>
                            <input class="form-control" type="text" value="{{$user->phone}}" name="phone">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>البريد الالكترونى</label>
                            <input class="form-control" type="email" value="{{$user->email}}" name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>اسم المستخدم</label>
                            <input class="form-control" type="text" value="{{$user->username}}" name="username">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="clip-upload">
                                <label for="file-input">
                                    <i class="fa fa-camera" aria-hidden="true" style="font-size: 20px;color: #1E99A8"></i>
                                    <span style="font-size: 20px; color: #1E99A8">الصوره</span>
                                </label>
                                <img src="{{$user->photo}}" class="img-responsive mr-bot-15 btn-product-image "
                                     style="cursor:pointer; height: 150px; width: 150px;">
                                <input type="file" style="display:none;" name="photo" class="btn-product-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer-15"></div>
                <div class="col-sm-12 save-btn">
                    <button class="custom-btn green-bc" type="submit">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
@endsection
