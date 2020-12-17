@extends('admin.layouts.master')
@section('title')
    الصفحه الرئيسيه
@endsection
@section('content')
    <div class="content">
        <div class="col-sm-12 page-heading">
            <div class="col-sm-6">
                <h2>الصفحه الرئيسيه</h2>
            </div><!--End col-md-6-->
            <div class="col-sm-6">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.home')}}">لوحة التحكم</a></li>
                    <li class="active">الصفحه الرئيسيه</li>
                </ul>
            </div><!--End col-md-6-->
        </div>

    </div>
@endsection
