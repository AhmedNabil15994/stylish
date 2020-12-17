@extends('admin.layouts.master')
@section('title')
    المنتجات
@endsection

@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>عدد المنتجات: {{$rows->total()}}</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">المنتجات</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <a class="btn btn-info" href="{{route('admin.products.create')}}">أضف عنصر جديد</a>
        <div class="spacer-15"></div>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10"> القسم </label>
                        <select class="form-control" name="category_id">
                            <option selected value>القسم </option>
                            @foreach($main_categories as $main_category)
                                <option value="{{$main_category->id}}" {{request()->category_id == $main_category->id ? 'selected' : ''}}>{{$main_category->translate('ar')->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">اسم المنج</label>
                        <input type="text" class="form-control" value="{{request()->name}}"  name="name" placeholder="Name"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">المقاس</label>
                        <select class="form-control" name="size" id="insertSubCats">
                            <option value>اختر المقاس</option>
                            <option value="1" {{request()->size == 1 ? 'selected' : '' }}>صغير</option>
                            <option value="2" {{request()->size == 2 ? 'selected' : '' }}>متوسط</option>
                            <option value="3" {{request()->size == 3 ? 'selected' : '' }}>لارج</option>
                            <option value="4" {{request()->size == 4 ? 'selected' : '' }}>اكس لارج</option>
                            <option value="5" {{request()->size == 5 ? 'selected' : '' }}>2 اكس لارج</option>
                            <option value="6" {{request()->size == 6 ? 'selected' : '' }}>3 اكس لارج</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label mb-10">السعر من</label>
                        <input type="number" class="form-control" value="{{request()->price_from}}" name="price_from" placeholder="120"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label mb-10">السعر الى</label>
                        <input type="number" class="form-control" value="{{request()->price_to}}" name="price_to" placeholder="200"/>
                    </div>
                </div>
            </div>
            <div class="spacer-15"></div>
            <div class="col-sm-12 save-btn">
                <button class="custom-btn green-bc" type="submit">حفظ</button>
                <a href="{{route('admin.products.index')}}" class="btn btn-primary">أعادة</a>
            </div>
        </form>
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
                            <th class="text-center">القسم</th>
                            <th class="text-center">تاريخ الاضافة</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->translate('ar')->name}}</td>
                                <td>{{$row->category->translate('ar')->name}}</td>
                                <td>{{$row->created_at->format('Y-m-d')}}</td>
                                <td class="text-center">

                                    <a href="{{route('admin.products.edit',['id' => $row->id])}}" class="btn-modal-view icon-btn green-bc">
                                        <i class="fa fa-pencil"></i>
                                        تعديل
                                    </a>
                                    <button data-url="{{route('admin.products.destroy',['id' => $row->id])}}" data-toggle="modal" data-target="#delete_user" class="icon-btn red-bc deleteBTN">
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
