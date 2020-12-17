@extends('admin.layouts.master')
@section('title')
    الاعضاء
@endsection

@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>عدد الاعضاء: {{$rows->total()}}</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الاعضاء</li>
                </ul>
            </div><!--End col-md-6-->
        </div>

        <div class="spacer-15"></div>
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label mb-10">اسم المسخدم</label>
                        <input type="text" class="form-control" value="{{request()->name}}"  name="name" placeholder="اسم المسخدم"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label mb-10">رقم المسخدم</label>
                        <input type="text" class="form-control" value="{{request()->phone}}"  name="phone" placeholder="رقم المسخدم"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label mb-10">الحالة</label>
                        <select class="form-control" name="active">
                            <option value>اختر الحالة</option>
                            <option value="1" {{request()->active == 1 ? 'selected' : '' }}>مفعل</option>
                            <option value="3" {{request()->active == 3 ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="spacer-15"></div>
            <div class="col-sm-12 save-btn">
                <button class="custom-btn green-bc" type="submit">حفظ</button>
                <a href="{{route('admin.users.index')}}" class="btn btn-primary">أعادة</a>
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
                            <th class="text-center">رقم الهاتف</th>
                            <th class="text-center">البريد الالكترونى</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->f_name.' '.$row->l_name}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->email}}</td>
                                <td>
                                    <select name="active" class="form-control input-circle changeStatus" data-id="{{$row->id}}">
                                        <option {{$row->status == 0 ? 'selected' : '' }} value="0">غير مفعل</option>
                                        <option {{$row->status == 1 ? 'selected' : '' }} value="1">مفعل</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button data-url="{{route('admin.users.destroy',['id' => $row->id])}}" data-toggle="modal" data-target="#delete_user" class="icon-btn red-bc deleteBTN">
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

@section('js')
    <script>
        $(document).on('change','.changeStatus',function (e) {
            e.preventDefault();
            $this = $(this);
            var id = $this.data('id');
            $.ajax({
                type: "get",
                data: {id:id,status:$this.val(),_token:'{{csrf_token()}}'}
            });
        });
    </script>

@endsection
