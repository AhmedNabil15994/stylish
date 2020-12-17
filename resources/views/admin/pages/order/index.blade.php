@extends('admin.layouts.master')
@section('title')
    الطلبات
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>عدد الطلبات: {{$rows->total()}}</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الطلبات</li>
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
                        <label class="control-label mb-10">النوع</label>
                        <select class="form-control" name="type">
                            <option value>اختر النوع</option>
                            <option value="3" {{request()->type == 3 ? 'selected' : '' }}>جاهز</option>
                            <option value="1" {{request()->type == 1 ? 'selected' : '' }}>تفصيل</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">الحالة</label>
                        <select class="form-control" name="order_status">
                            <option value>اختر الحالة</option>
                            <option value="-1" {{request()->order_status == -1 ? 'selected' : '' }}>الغاء</option>
                            <option value="3" {{request()->order_status == 3  ? 'selected' : '' }}>انتظار</option>
                            <option value="1" {{request()->order_status == 1 ? 'selected' : '' }}>تحضير</option>
                            <option value="2" {{request()->order_status == 2 ? 'selected' : '' }}>تسليم</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="spacer-15"></div>
            <div class="col-sm-12 save-btn">
                <button class="custom-btn green-bc" type="submit">حفظ</button>
                <a href="{{route('admin.orders.index')}}" class="btn btn-primary">أعادة</a>
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
                            <th class="text-center">رقم المستخدم</th>
                            <th class="text-center">تاريخ البروفة</th>
                            <th class="text-center">النوع</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->product->translate('ar')->name}}</td>
                                <td>{{$row->user->f_name . ' ' . $row->user->l_name}}</td>
                                <td>{{$row->user->phone}}</td>
                                <td>{{$row->test_date->format('Y-m-d')}}</td>
                                <td>{{$row->type == 0 ? 'جاهز' : 'تفصيل'}}</td>
                                <td>
                                    <select class="form-control" name="status" id="changeStatus" data-id="{{$row->id}}">
                                        <option value="-1" {{$row->status == -1 ? 'selected' : '' }}>الغاء</option>
                                        <option value="0" {{$row->status == 0 ? 'selected' : '' }}>انتظار</option>
                                        <option value="1" {{$row->status == 1 ? 'selected' : '' }}>تحضير</option>
                                        <option value="2" {{$row->status == 2 ? 'selected' : '' }}>تسليم</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_{{$row->id}}">
                                        <i class="fa fa-pencil"></i>
                                        عرض التفاصيل
                                    </button>
                                    <button data-url="{{route('admin.orders.destroy',['id' => $row->id])}}" data-toggle="modal" data-target="#delete_user" class="icon-btn red-bc deleteBTN">
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
                            <h5>{{$row->product->translate('ar')->name}}</h5>
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
                            <label class="col-form-label">رقم المستخدم :</label>
                            <h5>{{$row->user->phone}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">تاريخ البروفة :</label>
                            <h5>{{$row->test_date->format('Y-m-d')}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">النوع :</label>
                            <h5>{{$row->type == 0 ? 'جاهز' : 'تفصيل'}}</h5>
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
                            <label class="col-form-label"> اللون : {{$row->color_name}}</label>
                            <div style="background-color: {{$row->color_code}}">{{$row->color_code}}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">الحالة :</label>
                            <h5>{{$row->status_name}}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">الصورة الرئيسية :</label>
                            <img src="{{$row->product->main_photo}}"/>
                        </div>
                    </div>
                    <label class="col-form-label">الصور الفرعية :</label>
                    <div class="row">
                        @foreach($row->product->sub_photo as $image)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <img src="{{$image->full_url}}"/>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">الملاحضات :</label>
                            <h5>{{$row->notes}}</h5>
                        </div>
                    </div>
                    @if($row->type == 1)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">عرض الكتف :</label>
                                <h5>{{$row->details->shoulder_width}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">محيط الصدر :</label>
                                <h5>{{$row->details->chest_circumference}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">الوسط :</label>
                                <h5>{{$row->details->middle_body}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">الارداف :</label>
                                <h5>{{$row->details->buttocks}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">طول الذراع :</label>
                                <h5>{{$row->details->arm_length}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">محيط الذراع :</label>
                                <h5>{{$row->details->arm_circumference}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">الاسورة :</label>
                                <h5>{{$row->details->wristband}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">الطول الكلى :</label>
                                <h5>{{$row->details->overall_height}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">الكتف الواحد :</label>
                                <h5>{{$row->details->one_shoulder}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">طول الظهر :</label>
                                <h5>{{$row->details->back_length}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">من الكتف للصدر :</label>
                                <h5>{{$row->details->from_shoulder_to_chest}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">من الكتف للوسط :</label>
                                <h5>{{$row->details->from_shoulder_middle}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">طول الجيبة :</label>
                                <h5>{{$row->details->pocket_length}}</h5>
                            </div>
                        </div>
                    @endif
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
