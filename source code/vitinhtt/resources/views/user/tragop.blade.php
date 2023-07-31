@extends('user.layouts.client')
@section('title')
Trả góp
@endsection
@section('head')
    {{-- thêm css --}}
@endsection
@section('content')
<h1><a href="{{ route('tragop') }}">đây là trang Trả góp</a></h1>
<hr>
<h1><a href="{{ route('/') }}">Trang chủ</a></h1>
@endsection
@section('js')
    {{-- thêm js --}}
@endsection

