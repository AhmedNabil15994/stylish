@extends('admin.layouts.master')
@section('title')
    الملابس المستعملة
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>عدد الملابس المستعملة: {{$rows->total()}}</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الملابس المستعملة</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">اسم المسخدم</label>
                        <input type="text" class="form-control" value="{{request()->username}}"  name="username" placeholder="اسم المسخدم"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">رقم المسخدم</label>
                        <input type="text" class="form-control" value="{{request()->user_phone}}"  name="user_phone" placeholder="رقم المسخدم"/>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">الحالة</label>
                        <select class="form-control" name="active">
                            <option value>اختر الحالة</option>
                            <option value="1" {{request()->active == 1 ? 'selected' : '' }}>مفعل</option>
                            <option value="3" {{(request()->active == 3) ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">الاسم</label>
                        <input type="text" class="form-control" value="{{request()->name}}"  name="name" placeholder="الاسم"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">حالة المنتج</label>
                        <select class="form-control" name="utilize_status">
                            <option value>اختر حالة المنتج</option>
                            <option value="1" {{request()->utilize_status == 1 ? 'selected' : '' }}>سبئ</option>
                            <option value="2" {{request()->utilize_status == 2 ? 'selected' : '' }}>جيد</option>
                            <option value="3" {{request()->utilize_status == 3  ? 'selected' : '' }}>ممتاز</option>
                        </select>
                    </div>
                </div>
            </div>
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
                <a href="{{route('admin.utilizes.index')}}" class="btn btn-primary">أعادة</a>
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
                            <th class="text-center">اسم المنتج</th>
                            <th class="text-center">اسم المستخدم</th>
                            <th class="text-center">السعر</th>
                            <th class="text-center">تاريخ الاضافة</th>
                            <th class="text-center">حالة المنتج</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->user->f_name . ' ' . $row->user->l_name}}</td>
                                <td>{{$row->price}}</td>
                                <td>{{$row->created_at->format('Y-m-d')}}</td>
                                <td>{{$row->status_name}}</td>
                                <td>
                                    <select class="form-control" name="active" id="changeStatus" data-id="{{$row->id}}">
                                        <option value="1" {{$row->active == 1 ? 'selected' : '' }}>مفعل</option>
                                        <option value="0" {{$row->active == 0 ? 'selected' : '' }}>غير مفعل</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_{{$row->id}}">
                                        <i class="fa fa-pencil"></i>
                                        عرض التفاصيل
                                    </button>
                                    <button data-url="{{route('admin.utilizes.destroy',['id' => $row->id])}}" data-toggle="modal" data-target="#delete_user" class="icon-btn red-bc deleteBTN">
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

@section('models')
    @foreach($rows as $row)
    <div class="modal fade" id="exampleModal_{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تفاصيل الطلب</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">اسم المنتج :</label>
                            <h5>{{$row->name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">اسم القسم :</label>
                            <h5>{{$row->category->translate('ar')->name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">اسم المستخدم :</label>
                            <h5>{{$row->user->f_name . ' ' . $row->user->l_name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">تاريخ الاضافة :</label>
                            <h5>{{$row->created_at->format('Y-m-d')}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">المقاس :</label>
                            <h5>{{$row->size_name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">اللون :</label>
                            <h5 style="background-color: {{$row->color_code}}">{{$row->color_name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">السعر :</label>
                            <h5>{{$row->price}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">حالة المنتج :</label>
                            <h5>{{$row->status_name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">الحالة :</label>
                            <h5>{{$row->active_name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">العنوان :</label>
                            <h5>{{$row->address}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">رقم التواصل :</label>
                            <h5>{{$row->phone}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">الملاحضات :</label>
                            <h5>{{$row->notes}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">الصورة الرئيسية :</label>
                            <img src="{{$row->main_photo}}"/>
                        </div>
                    </div>
                    <label class="col-form-label">الصور الفرعية :</label>
                    <div class="row">
                        @foreach($row->sub_photo as $image)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <img src="{{$image->full_url}}"/>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@section('js')
    <script>
        $(document).on('change','#changeStatus',function () {
           let $this = $(this);
            let data = {status:$this.val(),id:$this.data('id')};
            $.ajax({
                data:data,
                success:function (result) {

                },
                error:function (errors) {
                    console.log(errors);
                }
            });
        });
    </script>
@endsection
