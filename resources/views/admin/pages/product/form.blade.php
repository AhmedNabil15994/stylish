@extends('admin.layouts.master')
@section('title')
    المنتجات
@endsection

@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>المنتجات</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">المنتجات</li>
                </ul>
            </div><!--End col-md-6-->
        </div>
        <div class="spacer-15"></div>
        <div class="widget">
            <form class="widget-content ajax-form" action="{{isset($product->id) ? route('admin.products.update',$product->id) : route('admin.products.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @isset($product->id)
                    @method('PUT')
                @endisset

                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> اسم المنتج{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$product->translate($locale)->name ?? null}}" placeholder=" اسم المنتج{{$locale}}" name="{{$locale}}[name]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10"> القسم </label>
                            <select class="form-control" name="category_id">
                                <option selected value>القسم </option>
                                @foreach($main_categories as $main_category)
                                     <option value="{{$main_category->id}}" {{$product->category_id == $main_category->id ? 'selected' : ''}}>{{$main_category->translate('ar')->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">السعر</label>
                            <input type="number" class="form-control" value="{{$product->price}}" name="price" placeholder="120"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">المقاس</label>
                            <select class="form-control" name="size" id="insertSubCats">
                               <option value="1" {{$product->size == 1 ? 'selected' : '' }}>صغير</option>
                               <option value="2" {{$product->size == 2 ? 'selected' : '' }}>متوسط</option>
                               <option value="3" {{$product->size == 3 ? 'selected' : '' }}>لارج</option>
                               <option value="4" {{$product->size == 4 ? 'selected' : '' }}>اكس لارج</option>
                               <option value="5" {{$product->size == 5 ? 'selected' : '' }}>2 اكس لارج</option>
                               <option value="6" {{$product->size == 6 ? 'selected' : '' }}>3 اكس لارج</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mb-10">اختار اللون</label>
                            <input type="color" class="form-control" name="color_code" value="{{$product->color_code}}"/>
                        </div>
                    </div>
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label mb-10"> اسم اللون{{$locale}}</label>
                                <input class="form-control input-circle" value="{{$product->translate($locale)->color_name ?? null}}" placeholder=" اسم اللون{{$locale}}" name="{{$locale}}[color_name]" />
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">عنوان الفرع</label>
                            <select class="form-control" name="address_id">
                                <option selected value>عنوان الفرع</option>
                                @foreach($addresses as $address)
                                    <option value="{{$address->id}}" {{$product->address_id == $address->id ? 'selected' : ''}}>{{$address->translate('ar')->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">الحالة</label>
                            <select class="form-control" name="status" id="insertSubCats">
                                <option value="1" {{$product->status == 1 ? 'selected' : '' }}>مفعل</option>
                                <option value="0" {{$product->status == 0 ? 'selected' : '' }}>غير مفعل</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label mb-10">عرض فى الصفحة الرئيسية</label>
                            <select class="form-control" name="in_home">
                                <option value="1" {{$product->in_home == 1 ? 'selected' : '' }}>نعم</option>
                                <option value="0" {{$product->in_home == 0 ? 'selected' : '' }}>لا</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($locales as $i=>$locale)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label mb-10"> وصف المنتج {{$locale}}</label>
                                <textarea class="form-control input-circle tiny-editor" placeholder=" وصف المنتج {{$locale}}"
                                          name="{{$locale}}[desc]">{{$product->translate($locale)->desc ?? null}}</textarea>
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
                                    <span style="font-size: 20px; color: #1E99A8">الصورة الرئيسية</span>
                                </label>
                                <img src="{{$product->main_photo}}" class="img-responsive mr-bot-15 btn-product-image "
                                     style="cursor:pointer; height: 150px; width: 150px;">
                                <input type="file" style="display:none;" name="main" class="btn-product-image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label mb-10">الصور الفرعية</label>
                            <input class="form-control" type="file"  multiple name="photo[]" />
                        </div>
                    </div>
                </div>
                @if(Route::is('admin.products.edit'))
                    <div class="row">
                        @foreach($product->sub_photo as $sub)
                            <div class="col-md-2">
                                <img src="{{$sub->full_url}}">
                                <a href="{{route('admin.products.delete-image',$sub->id)}}" class="deleteImage">حذف</a>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="spacer-15"></div>
                <div class="alert alert-success hidden SuccessMessage" id=""></div>
                <div class="alert alert-danger hidden ErrorMessage" id=""></div>
                <div class="col-sm-12 save-btn">
                    <button class="custom-btn green-bc" type="submit">حفظ</button>
                    <a href="{{route('admin.products.index')}}" class="btn btn-primary" type="submit">الغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).on('click','.deleteImage',function (e) {
            e.preventDefault();
            let $this = $(this);
            let url =$this.attr('href');
            $.ajax({
                url:url,
                success:function (response) {
                    if (response.status === "success") {
                        var alertSelector = '.SuccessMessage';
                        var alertOpSelector = '.ErrorMessage';
                        $this.parent().remove();
                    } else if (response.status === "error") {
                        var alertSelector = '.ErrorMessage';
                        var alertOpSelector = '.SuccessMessage';
                    }
                    $(alertSelector).html(response.data);
                    $(alertSelector).hide().removeClass('hidden').fadeIn();
                    setTimeout(function () {
                        $(alertSelector).fadeOut().addClass('hidden');
                    }, 3000);
                    $(alertOpSelector).fadeOut().addClass('hidden');
                },
                error:function (errors) {
                    console.log(errors);
                }
            });
        });

    </script>
@endsection
