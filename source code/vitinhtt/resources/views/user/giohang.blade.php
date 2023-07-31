@extends('user.layouts.client')
@section('title')
    Giỏ hàng
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
                    <li class="active"><a href="{{ route('giohang') }}">Giỏ hàng</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--Shopping Cart Area Strat-->
    <div class="Shopping-cart-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('xulygiohang') }}" method="post">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="li-product-remove">xóa</th>
                                        <th class="li-product-thumbnail">hình ảnh</th>
                                        <th class="cart-product-name">sản phẩm</th>
                                        <th class="li-product-price">giá bán</th>
                                        <th class="li-product-quantity">số lượng</th>
                                        <th class="li-product-subtotal">thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tongTienGioHang = 0;
                                        $thanhTienGioHang = 0;
                                    @endphp
                                    <input hidden id="maSanPhamXoa" value="0" type="number" name="maSanPhamMuaXoa"
                                        required>
                                    @if (!empty(session('gioHang')))
                                        @foreach (session('gioHang') as $ctgh)
                                            <tr>
                                                <td class="li-product-remove">
                                                    <button onclick="xoaSanPhamTrongSession({{ $ctgh['masanpham'] }})" type="submit"
                                                        class="btn btn-focus p-0 pr-1 pl-1" name="thaoTac" title="Xóa"
                                                        value="xóa giỏ hàng" style='color:#555'><i
                                                            class='fa fa-times'></i></button>
                                                </td>
                                                <td class="li-product-thumbnail hinh-giohang p-2"><a
                                                        href="{{ url('chitietsp?masp=' . $ctgh['masanpham']) }}"><img
                                                            src="{{ asset('img/sanpham/' . $ctgh['hinh']) }}"
                                                            alt="Li's Product Image"></a></td>
                                                <td class="li-product-name cantrai p-0 pl-25"><a class="mauchu-link"
                                                        href="{{ url('chitietsp?masp=' . $ctgh['masanpham']) }}">[SP{{ $ctgh['masanpham'] }}]
                                                        - {{ $ctgh['tensanpham'] }}</a>
                                                </td>
                                                <td class="li-product-price canphai p-0 pr-25">
                                                    @if (!empty($ctgh['giakhuyenmai']))
                                                        <span
                                                            class="amount">{{ number_format($ctgh['giakhuyenmai'], 0, ',') }}đ</span>
                                                        @php
                                                            $thanhTienGioHang = $ctgh['soluongmua'] * $ctgh['giakhuyenmai'];
                                                            $tongTienGioHang += $thanhTienGioHang;
                                                        @endphp
                                                    @else
                                                        <span
                                                            class="amount">{{ number_format($ctgh['giaban'], 0, ',') }}đ</span>
                                                        @php
                                                            $thanhTienGioHang = $ctgh['soluongmua'] * $ctgh['giaban'];
                                                            $tongTienGioHang += $thanhTienGioHang;
                                                        @endphp
                                                    @endif
                                                </td>
                                                <td class="quantity p-0">
                                                    <div class="cart-plus-minus">
                                                        <input title="(Gồm các ký tự là số)" class="cart-plus-minus-box"
                                                            value="{{ $ctgh['soluongmua'] }}" pattern="[0-9]*"
                                                            name="soLuongMuaSua[{{ $ctgh['masanpham'] }}]" type="text"
                                                            required>
                                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal canphai p-0 pr-25"><span
                                                        class="amount">{{ number_format($thanhTienGioHang, 0, ',') }}đ</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    @if (empty(session('maGiamGia')))
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="maGiamGia"
                                                pattern="[A-Za-z0-9]{3,50}" value="{{ old('maGiamGia') }}"
                                                title="(Gồm các ký tự là chữ thường, in hoa hoặc số, không dấu và không khoảng cách, tối đa 50 ký tự)"
                                                placeholder="Mã giảm giá" type="text">
                                            <input class="button ml-1" name="thaoTac" value="áp dụng" type="submit">
                                        </div>
                                    @endif
                                    <div class="coupon2">
                                        <input class="button" name="thaoTac" value="cập nhật" type="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('maGiamGia')
                            <div class="row">
                                <div class="col-2">
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                </div>
                            </div>
                        @enderror
                        <div class="row">
                            <div class="col-md-5 ml-auto">
                                <div class="cart-page-total">
                                    <h2>giỏ hàng</h2>
                                    <ul>
                                        <li>Tổng cộng: <span>{{ number_format($tongTienGioHang, 0, ',') }}đ</span></li>
                                        @if (!empty(session('maGiamGia')))
                                            @php
                                                $tongTienGioHang -= session('maGiamGia')->sotiengiam;
                                                if($tongTienGioHang<0) $tongTienGioHang = 0;
                                            @endphp
                                            <li>Giảm ({{ session('maGiamGia')->magiamgia }}):
                                                <span>-{{ number_format(session('maGiamGia')->sotiengiam, 0, ',') }}đ</span>
                                            </li>
                                        @endif
                                        <li style="color:#EB3E32">CẦN THANH TOÁN:
                                            <span>{{ number_format($tongTienGioHang, 0, ',') }}đ</span>
                                        </li>
                                    </ul>
                                    <a style="float: right;" href="{{ route('thanhtoan') }}">Thanh toán</a>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Shopping Cart Area End-->
@endsection
@section('js')
    {{-- thêm js --}}
@endsection
