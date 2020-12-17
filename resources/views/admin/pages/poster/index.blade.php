@extends('admin.layouts.master')
@section('title')
    اعلان
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
        <a class="btn btn-info" href="{{route('admin.posters.create')}}">أضف عنصر جديد</a>
        <div class="spacer-15"></div>
        <div class="widget">
            <div class="widget-content">
                <div class="spacer-15"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr >
                            <th class="text-center">#</th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center">الرابط</th>
                            <th class="text-center">الصورة</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->translate('ar')->title}}</td>
                                <td>{{ $row->url }}</td>
                                <td>
                                    <img src="{{$row->photo}}" width="20%" class="img-responsive mr-bot-15 btn-product-image " />
                                </td>
                                <td class="text-center">

                                    <a href="{{route('admin.posters.edit',['id' => $row->id])}}" class="btn-modal-view icon-btn green-bc">
                                        <i class="fa fa-pencil"></i>
                                        تعديل
                                    </a>
                                    <button data-url="{{route('admin.posters.destroy',['id' => $row->id])}}" data-toggle="modal" data-target="#delete_user" class="icon-btn red-bc deleteBTN">
                                        <i class="fa fa-trash-o"></i>
                                        حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $rows->links() !!}
            </div>
        </div>
    </div>
@endsection
