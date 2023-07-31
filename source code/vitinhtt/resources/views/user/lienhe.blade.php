@extends('user.layouts.client')
@section('title')
    Liên hệ
@endsection
@section('head')
    {{-- thêm css --}}
    <style>
        #checkout-mess{
            line-height:17px;
            padding: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('/') }}">Trang chủ</a></li>
                    <li class="active"><a href="{{ route('lienhe') }}">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-6 p-0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15679.817641153899!2d106.6778321!3d10.7379972!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x674d5126513db295!2zVHLGsOG7nW5nIMSQ4bqhaSBI4buNYyBDw7RuZyBOZ2jhu4cgU8OgaSBHw7Ju!5e0!3m2!1svi!2s!4v1635321257382!5m2!1svi!2s"
                    style="border:1; height: 100%" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-6 p-0">
                <div class="banner-lienhe">
                    <div class="container"></div>
                    <img src="{{ asset('img/banner/lienhe1.png') }}" alt="" style="width: 100%;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-5">
                <div class="contact-form-content pt-sm-55 pt-xs-55 pt-50 mb-50">
                    <h3 class="contact-page-title">Liên hệ với chúng tôi</h3>
                    <div class="contact-form">
                        <form action="{{ route('xulylienhe') }}" method="post">
                            <div class="form-group">
                                <label class="mb-0">Họ tên <span class="required">*</span></label>
                                @error('hoTen')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                                <input
                                    title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                    name="hoTen"
                                    value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->hoten : old('hoTen') }}"
                                    pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                    type="text" required
                                    {{ auth()->check() && auth()->user()->loainguoidung != 2 ? 'disabled' : '' }}>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">SĐT <span class="required">*</span></label>
                                @error('soDienThoai')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                                <input
                                    value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->sodienthoai : old('soDienThoai') }}"
                                    title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                    name="soDienThoai" pattern="^[0]\d{9}$" type="text" required
                                    {{ auth()->check() && auth()->user()->loainguoidung != 2 ? 'disabled' : '' }}>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Địa chỉ <span class="required">*</span></label>
                                @error('diaChi')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                                <input
                                    value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->diachi : old('diaChi') }}"
                                    title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                    name="diaChi"
                                    pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                    type="text" required
                                    {{ auth()->check() && auth()->user()->loainguoidung != 2 ? 'disabled' : '' }}>
                            </div>
                            @if (auth()->check() && auth()->user()->loainguoidung != 2)
                                <input
                                    title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                    name="hoTen"
                                    value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->hoten : old('hoTen') }}"
                                    pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                    type="text" required hidden>
                                <input
                                    value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->sodienthoai : old('soDienThoai') }}"
                                    title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                    name="soDienThoai" pattern="^[0]\d{9}$" type="text" required hidden>
                                <input
                                    value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->diachi : old('diaChi') }}"
                                    title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                    name="diaChi"
                                    pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                    type="text" required hidden>
                            @endif
                            <div class="form-group mb-20">
                                <label class="mb-0">Lời nhắn <span class="required">*</span></label>
                                @error('noiDung')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                                <textarea name="noiDung" id="checkout-mess" cols="30" rows="10" required
                                    placeholder="VD: Tôi cần tư vấn mua laptop qua số điện thoại,...">{{ old('noiDung') != null ? old('noiDung') : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" value="gửi lời nhắn" id="guiLoiNhan" class="li-btn-3" name="thaoTac"
                                    style="font-weight:400;float: right;">Gửi</button>
                            </div>
                            @csrf
                            <div style="clear: both;"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-form-content pt-sm-55 pt-xs-55 pt-50">
                    <div class="fb-page" data-href="https://www.facebook.com/vitinhtt61/?ref=page_internal"
                        data-tabs="timeline" data-width="470" data-height="580" data-small-header="false"
                        data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="https://www.facebook.com/vitinhtt61/?ref=page_internal"
                            class="fb-xfbml-parse-ignore"><a
                                href="https://www.facebook.com/vitinhtt61/?ref=page_internal">Vi Tính T&amp;T</a>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v14.0&appId=547638056845645&autoLogAppEvents=1"
        nonce="misuiOvN"></script>
@endsection
