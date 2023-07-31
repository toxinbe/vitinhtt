@extends('user.layouts.client')
@section('title')
    Thanh toán
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
                    <li class="active"><a href="{{ route('thanhtoan') }}">Thanh toán</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--Checkout Area Strat-->
    <div class="checkout-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="coupon-accordion">
                        @if (!auth()->check())
                            <!--Accordion Start-->
                            <h3><i class="fa fa-question-circle-o mr-10"></i>Bạn đã có tài khoản? <span id="showlogin">Click
                                    để
                                    đăng nhập</span></h3>
                            <div id="checkout-login" class="coupon-content">
                                @if (!empty(session('loidangnhap')))
                                    <div class="alert alert-danger">
                                        <strong>Thất bại! </strong> {{ session('loidangnhap') }}
                                    </div>
                                @endif
                                <div class="coupon-info">
                                    <form action="{{ route('xulytaikhoan') }}" method="post">
                                        <p class="form-row-first">
                                            <label class="mb-0">Email <span class="required">*</span>
                                                @error('email')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
                                            </label>
                                            <input name="email" value="{{ old('email') }}"
                                                pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                                type="email" required>
                                        </p>
                                        <p class="form-row-last">
                                            <label class="mb-0">Mật khẩu <span class="required">*</span>
                                                @error('matKhau')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
                                            </label>
                                            <input name="matKhau"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                                title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                                type="password" required>
                                        </p>
                                        <p class="form-row m-0">
                                            <input name="thaoTac" value="đăng nhập" type="submit">
                                            <label>
                                                <a href="#">Quên mật khẩu?</a>
                                            </label>
                                        </p>
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <!--Accordion End-->
                        @endif
                        @if (empty(session('maGiamGia')))
                            <!--Accordion Start-->
                            <h3><i class="fa fa-question-circle-o mr-10"></i>Bạn chưa nhập mã khuyến mãi? <span
                                    id="showcoupon">Click để nhập mã</span></h3>
                            <div id="checkout_coupon" class="coupon-checkout-content">
                                <div class="coupon-info">
                                    <form action="{{ route('xulygiohang') }}" method="post">
                                        <p class="checkout-coupon">
                                            <input id="coupon_code" class="input-text" name="maGiamGia"
                                                pattern="[A-Za-z0-9]{3,50}" value="{{ old('maGiamGia') }}"
                                                title="(Gồm các ký tự là chữ thường, in hoa hoặc số, không dấu và không khoảng cách, tối đa 50 ký tự)"
                                                placeholder="Mã giảm giá" type="text" required>
                                            <input class="button ml-1 nutapdung" name="thaoTac" value="áp dụng" type="submit">
                                        </p>
                                        @error('maGiamGia')
                                            <div class="row">
                                                <div class="col-2">
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                </div>
                                            </div>
                                        @enderror
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <!--Accordion End-->
                        @endif
                    </div>
                </div>
            </div>
            <form action="{{ route('xulythanhtoan') }}" method="post" enctype="application/x-www-form-urlencoded">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="checkbox-form">
                            <h3>Thông tin</h3>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Thất bại! </strong> Dữ liệu nhập vào không chính xác.
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Họ tên <span class="required">*</span></label>
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
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Số điện thoại <span class="required">*</span></label>
                                        @error('soDienThoai')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                        <input
                                            value="{{ auth()->check() && auth()->user()->loainguoidung != 2 ? auth()->user()->sodienthoai : old('soDienThoai') }}"
                                            title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                            name="soDienThoai" pattern="^[0]\d{9}$" type="text" required
                                            {{ auth()->check() && auth()->user()->loainguoidung != 2 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Địa chỉ <span class="required">*</span></label>
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
                                </div>
                                <div class="col-md-12">
                                    <div class="country-select clearfix">
                                        <label>Hình thức thanh toán <span class="required">*</span></label>
                                        @error('hinhThucThanhToan')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                        <select class="nice-select wide" name="hinhThucThanhToan" required>
                                            @if (old('hinhThucThanhToan') != null)
                                                @if (old('hinhThucThanhToan') == 0)
                                                    <option value="{{ old('hinhThucThanhToan') }}" selected hidden>
                                                        Tiền mặt</option>
                                                @elseif(old('hinhThucThanhToan') == 1)
                                                    <option value="{{ old('hinhThucThanhToan') }}" selected hidden>
                                                        Chuyển khoản</option>
                                                @elseif(old('hinhThucThanhToan') == 2)
                                                    <option value="{{ old('hinhThucThanhToan') }}" selected hidden>
                                                        ATM qua VNPAY</option>
                                                @endif
                                            @endif
                                            <option value="0">Tiền mặt</option>
                                            <option value="1">Chuyển khoản</option>
                                            <option value="2">ATM qua VNPAY</option>
                                        </select>
                                    </div>
                                </div>
                                @if (!auth()->check())
                                    <div class="col-md-12">
                                        <div class="checkout-form-list create-acc">
                                            <label><input id="cbox" type="checkbox" name="taoTaiKhoan">Tạo tài
                                                khoản?</label>
                                            <p style="font-size:12px;margin-bottom:0px">(Để có thể theo dõi đơn hàng và
                                                được
                                                tặng ngẫu nhiên mã giảm giá mỗi khi đăng nhập)</p>
                                        </div>
                                        <div id="cbox-info" class="checkout-form-list create-account">
                                            <p>Tạo tài khoản bằng cách nhập thông tin bên dưới. Nếu bạn là khách hàng cũ,
                                                vui
                                                lòng đăng nhập ở đầu trang.</p>
                                            <label>Email <span class="required">*</span></label>
                                            @error('email')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                            <input class="mb-15" name="email" id="email"
                                                value="{{ old('email') }}" disabled
                                                pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                                type="email">
                                            <label>Mật khẩu <span class="required">*</span></label>
                                            @error('matKhau')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                            <input class="mb-15" id="matKhau" name="matKhau" disabled
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                                title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                                type="password" required>
                                            <label>Nhập lại mật khẩu <span class="required">*</span></label>
                                            @error('nhapLaiMatKhau')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                            <input class="mb-15" name="nhapLaiMatKhau" id="nhapLaiMatKhau"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}" disabled
                                                title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                                type="password">
                                        </div>
                                    </div>
                                @elseif(auth()->check() && auth()->user()->loainguoidung != 2)
                                    <input
                                        title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                        name="hoTen"
                                        value="{{ auth()->user()->hoten }}"
                                        pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                        type="text" required hidden>
                                    <input
                                        value="{{ auth()->user()->sodienthoai }}"
                                        title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                        name="soDienThoai" pattern="^[0]\d{9}$" type="text" required hidden>
                                    <input
                                        value="{{ auth()->user()->diachi }}"
                                        title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                        name="diaChi"
                                        pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                        type="text" required hidden>
                                @endif
                            </div>
                            <div class="different-address">
                                <div class="checkout-form-list create-acc">
                                    <label><input id="ship-box" type="checkbox" name="thongTinNguoiNhanKhac">Giao
                                        đến
                                        địa chỉ khác?</label>
                                </div>
                                <div id="ship-box-info" class="row">
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Họ tên người nhận <span class="required">*</span></label>
                                            @error('hoTenNguoiNhan')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                            <input
                                                title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                                name="hoTenNguoiNhan" id="hoTenNguoiNhan"
                                                value="{{ old('hoTenNguoiNhan') }}" disabled
                                                pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Số điện thoại người nhận <span class="required">*</span></label>
                                            @error('soDienThoaiNguoiNhan')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                            <input
                                                title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                                name="soDienThoaiNguoiNhan" id="soDienThoaiNguoiNhan" disabled
                                                value="{{ old('soDienThoaiNguoiNhan') }}" pattern="^[0]\d{9}$"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Địa chỉ người nhận <span class="required">*</span></label>
                                            @error('diaChiNguoiNhan')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                            <input
                                                title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                                name="diaChiNguoiNhan" id="diaChiNguoiNhan"
                                                value="{{ old('diaChiNguoiNhan') }}" disabled
                                                pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                                type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="order-notes">
                                    <div class="checkout-form-list">
                                        <label>Ghi chú</label>
                                        @error('ghiChu')
                                            <span style="color: red;font-size:10px">{{ $message }}</span>
                                        @enderror
                                            <textarea name="ghiChu" id="checkout-mess" cols="30" rows="10"
                                                placeholder="VD: Chỉ nhận hàng trong giờ hành chính,...">{{ old('ghiChu') != null ? old('ghiChu') : ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="your-order">
                            <h3>Đơn hàng</h3>
                            <div class="your-order-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="cart-product-name cantrai pl-50" style="width:55%">sản phẩm
                                            </th>
                                            <th class="cart-product-total">thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tongTienGioHang = 0;
                                            $thanhTienGioHang = 0;
                                        @endphp
                                        @if (!empty(session('gioHang')))
                                            @foreach (session('gioHang') as $ctgh)
                                                <tr class="cart_item">
                                                    <td class="cart-product-name cantrai pl-20">
                                                        [SP{{ $ctgh['masanpham'] }}] -
                                                        {{ $ctgh['tensanpham'] }}<strong class="product-quantity"> ×
                                                            {{ $ctgh['soluongmua'] }}</strong>
                                                        @if (!empty($ctgh['quatang']))
                                                            @php
                                                                $flag = false;
                                                            @endphp
                                                            @foreach ($ctgh['quatang'] as $sanPhamTang)
                                                                @if (!$flag)
                                                                    <p class="m-0 mt-1"
                                                                        style="font-size:10px;line-height:15px;color: #333"><i style="color: #007bff"
                                                                            class="fa fa-gift"></i>
                                                                        [SP{{ $sanPhamTang->masanpham }}] -
                                                                        {{ $sanPhamTang->tensanpham }} x
                                                                        {{ $ctgh['soluongmua'] }}</p>
                                                                    @php
                                                                        $flag = true;
                                                                    @endphp
                                                                @else
                                                                    <p class="m-0"
                                                                        style="font-size:10px;line-height:15px;color: #333"><i style="color: #007bff"
                                                                            class="fa fa-gift"></i>
                                                                        [SP{{ $sanPhamTang->masanpham }}] -
                                                                        {{ $sanPhamTang->tensanpham }} x
                                                                        {{ $ctgh['soluongmua'] }}</p>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    @if (!empty($ctgh['giakhuyenmai']))
                                                        @php
                                                            $thanhTienGioHang = $ctgh['soluongmua'] * $ctgh['giakhuyenmai'];
                                                            $tongTienGioHang += $thanhTienGioHang;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $thanhTienGioHang = $ctgh['soluongmua'] * $ctgh['giaban'];
                                                            $tongTienGioHang += $thanhTienGioHang;
                                                        @endphp
                                                    @endif
                                                    <td class="cart-product-total canphai pr-20"><span
                                                            class="amount tensanpham">{{ number_format($thanhTienGioHang, 0, ',') }}đ</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <input type="number" hidden id="tongTien" name="tongTien"
                                            value="{{ $tongTienGioHang }}" required>
                                        @if (!empty(session('maGiamGia')))
                                            <tr class="cart_item">
                                                <td class="cart-product-name cantrai pl-20">
                                                    Tổng cộng:
                                                </td>
                                                <td class="cart-product-total canphai pr-20">
                                                    <span
                                                        class="amount tensanpham">{{ number_format($tongTienGioHang, 0, ',') }}đ</span>
                                                </td>
                                            </tr>
                                            @php
                                                $tongTienGioHang -= session('maGiamGia')->sotiengiam;
                                                if($tongTienGioHang<0) $tongTienGioHang = 0;
                                            @endphp
                                            <tr class="cart_item">
                                                <td class="cart-product-name cantrai pl-20">
                                                    Giảm ({{ session('maGiamGia')->magiamgia }}):
                                                </td>
                                                <td class="cart-product-total canphai pr-20"><span
                                                        class="amount tensanpham">-{{ number_format(session('maGiamGia')->sotiengiam, 0, ',') }}đ</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="order-total">
                                            <th class="cantrai pl-20">Cần thanh toán:
                                                @error('tongTien')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
                                            </th>
                                            <td class="canphai pr-20"><strong><span
                                                        class="amount">{{ number_format($tongTienGioHang, 0, ',') }}đ</span></strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="payment-method">
                                <div class="payment-accordion">
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header" id="#payment-1">
                                                <h5 class="panel-title">
                                                    <a class="" data-toggle="collapse" data-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        Thanh toán Tiền mặt
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>Sau khi ấn ĐẶT HÀNG trong 24h sẽ có nhân viên liên hệ bạn để xác nhận đơn và
                                                        giao đến tận nơi. Khi nhận được hàng bạn có thể kiểm tra sản phẩm và
                                                         thanh toán trực tiếp cho nhân viên giao hàng.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="#payment-2">
                                                <h5 class="panel-title">
                                                    <a class="collapsed" data-toggle="collapse"
                                                        data-target="#collapseTwo" aria-expanded="false"
                                                        aria-controls="collapseTwo">
                                                        Thanh toán Chuyển khoản
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>Sau khi ấn ĐẶT HÀNG trong 24h sẽ có nhân viên liên hệ bạn để xác nhận đơn và
                                                        giao đến tận nơi. Khi nhận được hàng bạn có thể kiểm tra sản phẩm và
                                                         thanh toán trực tiếp cho nhân viên giao hàng.
                                                        Bạn có thể chuyển khoản theo sự hướng dẫn của nhân viên liên hệ khi xác nhận đơn hoặc theo sự hướng dẫn của nhân viên giao hàng khi đã nhận được hàng</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="#payment-3">
                                                <h5 class="panel-title">
                                                    <a class="collapsed" data-toggle="collapse"
                                                        data-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree">
                                                        Thanh toán ATM qua VNPAY
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>Sau khi ấn ĐẶT HÀNG giao diện sẽ xuất hiện MÃ QR và SỐ TIỀN CẦN THANH TOÁN.
                                                        Bạn có thể tiến hành quét mã trên App VNPAY và thực hiện thao tác chuyển
                                                        tiền hoặc điền thông tin theo biểu mẫu đã xuất hiện trực tiếp trên giao diện.
                                                        Sau khi thanh toán thành công giao diện sẽ thông báo.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-button-payment">
                                        <input id="datHang" value="đặt hàng" name="thaoTac" type="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
    <!--Checkout Area End-->
@endsection
@section('js')
    {{-- thêm js --}}
    <script>
        $('#ship-box').change(function() {
            var thongTinNguoiNhanKhac = document.getElementById('ship-box');
            var hoTenNguoiNhan = document.getElementById('hoTenNguoiNhan');
            var soDienThoaiNguoiNhan = document.getElementById('soDienThoaiNguoiNhan');
            var diaChiNguoiNhan = document.getElementById('diaChiNguoiNhan');
            hoTenNguoiNhan.required = thongTinNguoiNhanKhac.checked;
            hoTenNguoiNhan.disabled = !thongTinNguoiNhanKhac.checked;
            soDienThoaiNguoiNhan.required = thongTinNguoiNhanKhac.checked;
            soDienThoaiNguoiNhan.disabled = !thongTinNguoiNhanKhac.checked;
            diaChiNguoiNhan.required = thongTinNguoiNhanKhac.checked;
            diaChiNguoiNhan.disabled = !thongTinNguoiNhanKhac.checked;
        });
        $('#cbox').change(function() {
            var taoTaiKhoan = document.getElementById('cbox');
            var email = document.getElementById('email');
            var matKhau = document.getElementById('matKhau');
            var nhapLaiMatKhau = document.getElementById('nhapLaiMatKhau');
            email.required = taoTaiKhoan.checked;
            email.disabled = !taoTaiKhoan.checked;
            matKhau.required = taoTaiKhoan.checked;
            matKhau.disabled = !taoTaiKhoan.checked;
            nhapLaiMatKhau.required = taoTaiKhoan.checked;
            nhapLaiMatKhau.disabled = !taoTaiKhoan.checked;
        });
        $('#datHang').click(function() {
            var matKhau = document.getElementById('matKhau');
            var nhapLaiMatKhau = document.getElementById('nhapLaiMatKhau');
            if (matKhau.value != nhapLaiMatKhau.value) {
                nhapLaiMatKhau.value = null;
                alert("Mật khẩu và nhập lại mật khẩu không khớp nhau!");
            }
        });
    </script>
@endsection
