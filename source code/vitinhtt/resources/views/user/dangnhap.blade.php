@extends('user.layouts.client')
@section('title')
    Tài khoản
@endsection
@section('head')
    {{-- thêm css --}}
@endsection
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('/') }}">Trang chủ</a></li>
                    <li class="active"><a href="{{ route('dangnhap') }}">Đăng nhập - Đăng ký</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Begin Login Content Area -->
    <div class="page-section mt-10 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30">
                    <!-- Login Form s-->
                    <form action="{{ route('xulytaikhoan') }}" method="post">
                        <div class="login-form">
                            <h4 class="login-title">Đăng nhập</h4>
                            @if (!empty(session('loidangnhap')))
                                <div class="alert alert-danger">
                                    <strong>Thất bại! </strong> {{ session('loidangnhap') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12 col-12 mb-20">
                                    <label>Email <span class="required">*</span>
                                        @error('email')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="mb-0" name="email" id="email" value="{{ old('email') }}"
                                        pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                        title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                        type="email" required>
                                </div>
                                <div class="col-12 mb-20">
                                    <label>Mật khẩu <span class="required">*</span>
                                        @error('matKhau')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="mb-0" name="matKhau" id="matKhau"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                        title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                        type="password" required>
                                </div>
                                <div class="col-md-6 cantrai">
                                    <label>
                                        <a href="#" style="line-height: 36px;">Quên mật khẩu?</a>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <button style="float: right;" type="submit" name="thaoTac" value="đăng nhập"
                                        class="register-button mt-0">Đăng nhập</button>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                    <form action="{{ route('xulytaikhoan') }}" method="post">
                        <div class="login-form">
                            <h4 class="login-title">Đăng ký</h4>
                            @if (!empty(session('loidangky')))
                                <div class="alert alert-danger">
                                    <strong>Thất bại! </strong> {{ session('loidangky') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12 col-12 mb-20">
                                    <label>Email <span class="required">*</span>
                                        @error('emailDangKy')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="mb-0" name="emailDangKy" id="emailDangKy"
                                        value="{{ old('emailDangKy') }}"
                                        pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                        title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                        type="email" required>
                                </div>
                                <div class="col-6 mb-20">
                                    <label>Mật khẩu <span class="required">*</span>
                                        @error('matKhauDangKy')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="mb-0" name="matKhauDangKy" id="matKhauDangKy"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                        title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                        type="password" required>
                                </div>
                                <div class="col-6 mb-20">
                                    <label>Nhập lại mật khẩu <span class="required">*</span>
                                        @error('nhapLaiMatKhauDangKy')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="mb-0" name="nhapLaiMatKhauDangKy" id="nhapLaiMatKhauDangKy"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                        title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                        type="password" required>
                                </div>
                                <div class="col-6 mb-20">
                                    <label>Họ tên <span class="required">*</span>
                                        @error('hoTen')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="form-control"
                                        title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                        name="hoTen" value="{{ old('hoTen') }}" required
                                        pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                        type="text">
                                </div>
                                <div class="col-6 mb-20">
                                    <label>Số điện thoại <span class="required">*</span>
                                        @error('soDienThoai')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="form-control" required
                                        title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                        name="soDienThoai" value="{{ old('soDienThoai') }}" pattern="^[0]\d{9}$"
                                        type="text">
                                </div>
                                <div class="col-12 mb-20">
                                    <label>Địa chỉ <span class="required">*</span>
                                        @error('diaChi')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <input class="form-control" required
                                        title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                        name="diaChi" value="{{ old('diaChi') }}"
                                        pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                        type="text">
                                </div>
                                <div class="col-md-12">
                                    <button style="float: right;" type="submit" id="dangKy" name="thaoTac"
                                        value="đăng ký" class="register-button mt-0">Đăng ký</button>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content Area End Here -->
@endsection
@section('js')
    {{-- thêm js --}}
    <script>
        $('#dangKy').click(function() {
            var matKhau = document.getElementById('matKhauDangKy');
            var nhapLaiMatKhau = document.getElementById('nhapLaiMatKhauDangKy');
            if (matKhau.value != nhapLaiMatKhau.value) {
                nhapLaiMatKhau.value = null;
                alert("Mật khẩu và nhập lại mật khẩu không khớp nhau!");
            }
        });
    </script>
@endsection
