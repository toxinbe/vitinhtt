<!-- Modal them mau moi start-->
<div class="modal fade" id="themPhuKien" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Thêm mẫu phụ kiện mới</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulyphukien') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" style="font-size:14px !important;">Nhập thông tin theo mẫu bên dưới</p>
                    <div class="row">
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tên sản phẩm (*)</label>
                                <input name="tenSanPham" type="text" class="form-control"
                                    value="{{ old('tenSanPham') }}" required>
                                @error('tenSanPham')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Bảo hành (*)</label>
                                <select class="form-control" name="baoHanh" required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('baoHanh') != null)
                                        <option value="{{ old('baoHanh') }}" selected hidden>
                                            {{ old('baoHanh') }} tháng</option>
                                    @endif
                                    <option value="1">1 tháng</option>
                                    <option value="3">3 tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="9">9 tháng</option>
                                    <option value="12">12 tháng</option>
                                    <option value="24">24 tháng</option>
                                    <option value="36">36 tháng</option>
                                    <option value="48">48 tháng</option>
                                </select>
                                @error('baoHanh')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Hãng sản xuất (*)</label>
                                <select class="form-control" name="hangSanXuat" required>

                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (!empty($danhSachHangSanXuatPhuKien))
                                        @foreach ($danhSachHangSanXuatPhuKien as $hangSanXuat)
                                            @if ($hangSanXuat->mahang == old('hangSanXuat'))
                                                <option value="{{ $hangSanXuat->mahang }}" selected hidden>
                                                    {{ $hangSanXuat->tenhang }}
                                                </option>
                                            @endif
                                            <option value="{{ $hangSanXuat->mahang }}">
                                                {{ $hangSanXuat->tenhang }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('hangSanXuat')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tên loại phụ kiện (*)</label>
                                <select class="form-control" name="tenLoaiPhuKien" required>

                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('tenLoaiPhuKien') != null)
                                        <option value="{{ old('tenLoaiPhuKien') }}" selected hidden>
                                            {{ old('tenLoaiPhuKien') }}</option>
                                    @endif
                                    <option value="Phím">Phím</option>
                                    <option value="Chuột">Chuột</option>
                                    <option value="Tai nghe">Tai nghe</option>
                                    <option value="Usb">Usb</option>
                                </select>
                                @error('tenLoaiPhuKien')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Hình sản phẩm (tối đa 5
                                    hình) (*)</label>
                                <input class="form-control" name="hinhSanPham[]" type="file" multiple required>
                                @error('hinhSanPham')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                                @error('hinhSanPham.*')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Quà tặng (tối đa 5
                                    phụ kiện)</label>
                                <select class="form-control" name="quaTang[]">
                                    <option value>Chọn sản phẩm 1</option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}] -
                                                    {{ $sanPham->tensanpham }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('quaTang')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTang[]">
                                    <option value>Chọn sản phẩm 2</option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}] -
                                                    {{ $sanPham->tensanpham }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTang[]">
                                    <option value>Chọn sản phẩm 3</option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}] -
                                                    {{ $sanPham->tensanpham }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTang[]">
                                    <option value>Chọn sản phẩm 4</option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}] -
                                                    {{ $sanPham->tensanpham }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTang[]">
                                    <option value>Chọn sản phẩm 5</option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}] -
                                                    {{ $sanPham->tensanpham }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Mô tả</label>
                                @if (old('moTa') != null)
                                    <textarea name="moTa" rows="5" class="form-control">{{ old('moTa') }}</textarea>
                                @else
                                    <textarea name="moTa" rows="5" class="form-control"></textarea>
                                @endif
                                @error('moTa')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="thêm phụ kiện"
                        class="btn btn-primary">Thêm</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal them mau moi end-->
