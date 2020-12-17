@extends('admin.layouts.master')
@section('title')
    اعلان
@endsection
@section('models')

    <div id="common-modal" class="modal fade" role="dialog">

    </div>
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>اعلان</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">اعلان</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <div class="widget">
            <form class="widget-content ajax-form" action="{{isset($poster->id) ? route('admin.posters.update',$poster->id) : route('admin.posters.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($poster->id)
                    @method('PUT')
                @endisset

                <div class="alert alert-success hidden SuccessMessage" id=""></div>
                <div class="alert alert-danger hidden ErrorMessage" id=""></div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> العنوان{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$poster->translate($locale)->title ?? null}}" placeholder=" العنوان{{$locale}}" name="{{$locale}}[title]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> وصف الاعلان {{$locale}}</label>
                                <textarea class="form-control input-circle tiny-editor" placeholder=" وصف الاعلان {{$locale}}" name="{{$locale}}[description]">{{$poster->translate($locale)->description ?? null}}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">الرابط</label>
                            <input class="form-control input-circle" value="{{$poster->url ?? null}}" placeholder="URL" name="url" />
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
                                <img src="{{$poster->photo}}" class="img-responsive mr-bot-15 btn-product-image "
                                     style="cursor:pointer; height: 150px; width: 150px;">
                                <input type="file" style="display:none;" name="photo" class="btn-product-image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer-15"></div>
                <div class="col-sm-12 save-btn">
                    <button class="custom-btn green-bc" type="submit">حفظ</button>
                    <a href="{{route('admin.posters.index')}}" class="btn btn-primary" type="submit">الغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
