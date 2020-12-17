@extends('admin.layouts.master')
@section('title')
    مقدمي الخدمات
@endsection

@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>عدد مقدمي الخدمات: {{$rows->total()}}</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">مقدمي الخدمات</li>
                </ul>
            </div><!--End col-md-6-->
        </div>

        <div class="spacer-15"></div>
        <form method="get" action="{{ URL::current() }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10">رقم التليفون</label>
                        <input type="text" class="form-control" value="{{ request('phone') }}"  name="phone" placeholder="رقم التليفون"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label mb-10"> الحالة </label>
                        <select class="form-control" name="service_admin_active">
                            <option selected value>اختر الحالة </option>
                            <option value="0" {{ request('service_admin_active') != null && request('service_admin_active') == 0 ? 'selected' : '' }}>غير مفعل</option>
                            <option value="1" {{ request('service_admin_active') != null && request('service_admin_active') == 1 ? 'selected' : '' }}>مفعل</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 save-btn">
                <button class="custom-btn green-bc" type="submit">بحث</button>
                <a href="{{route('admin.services.users')}}" class="btn btn-primary">أعادة</a>
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
                            <th class="text-center">البريد الالكترونى</th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center">رقم الهاتف</th>
                            <th class="text-center">الخدمة</th>
                            <th class="text-center">العنوان</th>
                            <th class="text-center">ايام العمل</th>
                            <th class="text-center">ساعات العمل</th>
                            <th class="text-center">التكلفة</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">الاعمال</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{!empty($row->user_service['name']) ? $row->user_service['name'] : $row->f_name.' '.$row->l_name}}</td>
                                <td>{{!empty($row->user_service['phone']) ? $row->user_service['phone'] : $row->phone}}</td>
                                <td>{{!empty($row->user_service->service) ? $row->user_service->service->translate('ar')['title'] : ''}}</td>
                                <td>{{!empty($row->user_service['address']) ? $row->user_service['address'] : $row->address}}</td>
                                <td>{{!empty($row->user_service['work_days']) ? $row->user_service['work_days'] : ''}}</td>
                                <td>{{!empty($row->user_service['work_hours']) ? $row->user_service['work_hours'] : ''}}</td>
                                <td>{{!empty($row->user_service['price']) ? $row->user_service['price'] : ''}}</td>

                                <td>
                                    <select name="service_admin_active" class="form-control input-circle changeStatus" data-id="{{$row->id}}">
                                        <option {{$row->service_admin_active == 0 ? 'selected' : '' }} value="0">غير مفعل</option>
                                        <option {{$row->service_admin_active == 1 ? 'selected' : '' }} value="1">مفعل</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_{{$row->id}}">
                                        <i class="fa fa-eye"></i>
                                        عرض الاعمال
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
                    <h5 class="modal-title" id="exampleModalLabel">الاعمال</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($row['works'] as $work)
                    <div class="row">
                        <div class="col-xs-12">
                            <img src="{{ $work->photo }}" alt="" style="width: 100%;min-height: 150px;margin-bottom: 10px;">
                            <p style="margin-bottom: 0;">{{ $work->description }}</p>
                        </div>
                    </div>
                    <hr>
                    @endforeach
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
        $(document).on('change','.changeStatus',function (e) {
            e.preventDefault();
            $this = $(this);
            var id = $this.data('id');
            $.ajax({
                type: "get",
                data: {id:id,service_admin_active:$this.val(),_token:'{{csrf_token()}}'}
            });
        });
    </script>

@endsection
