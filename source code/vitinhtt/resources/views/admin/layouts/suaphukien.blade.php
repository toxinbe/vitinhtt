<!-- Modal sua thong tin start-->
<div class="modal fade" id="suaPhuKien" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Sửa thông tin</span>
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
                                <label style="font-size:12px !important;">Tên
                                    sản phẩm (*)</label>
                                <input id="tenSanPhamSua" name="tenSanPhamSua" type="text" class="form-control" required>
                                @error('tenSanPhamSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Bảo
                                    hành (*)</label>
                                <select class="form-control" name="baoHanhSua" required>
                                    <option id="baoHanhSua" selected hidden></option>
                                    <option value="1">1 tháng</option>
                                    <option value="3">3 tháng</option>
                                    <option value="6">6 tháng</option>
                                    <option value="9">9 tháng</option>
                                    <option value="12">12 tháng
                                    </option>
                                    <option value="24">24 tháng
                                    </option>
                                    <option value="36">36 tháng
                                    </option>
                                    <option value="48">48 tháng
                                    </option>
                                </select>
                                @error('baoHanhSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Hãng
                                    sản xuất (*)</label>
                                <select class="form-control" name="hangSanXuatSua" required>
                                    <option id="hangSanXuatSua" selected hidden></option>
                                    @if (!empty($danhSachHangSanXuatPhuKien))
                                        @foreach ($danhSachHangSanXuatPhuKien as $hangSanXuat_Sua)
                                            <option value="{{ $hangSanXuat_Sua->mahang }}">
                                                {{ $hangSanXuat_Sua->tenhang }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('hangSanXuatSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tên loại phụ kiện (*)</label>
                                <select class="form-control" name="tenLoaiPhuKienSua" required>
                                    <option id="tenLoaiPhuKienSua" selected hidden></option>
                                    <option value="Phím">Phím</option>
                                    <option value="Chuột">Chuột</option>
                                    <option value="Tai nghe">Tai nghe</option>
                                    <option value="Usb">Usb</option>
                                </select>
                                @error('tenLoaiPhuKienSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2" id="hinh1"></div>
                        <div class="col-lg-2" id="hinh2"></div>
                        <div class="col-lg-2" id="hinh3"></div>
                        <div class="col-lg-2" id="hinh4"></div>
                        <div class="col-lg-2" id="hinh5"></div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Hình
                                    sản phẩm (tối đa 5
                                    hình) (*)</label>
                                <input class="form-control" name="hinhSanPhamSua[]" type="file" multiple>
                                @error('hinhSanPhamSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                                @error('hinhSanPhamSua.*')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Quà
                                    tặng (tối đa 5
                                    phụ kiện)</label>
                                <select class="form-control" name="quaTangSua[]">
                                    <option value>Bỏ chọn sản phẩm 1
                                    </option>
                                    <option id="quaTangSua0" hidden></option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}]
                                                    -
                                                    {{ $sanPham->tensanpham }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('quaTangSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTangSua[]">
                                    <option value>Bỏ chọn sản phẩm 2
                                    </option>
                                    <option id="quaTangSua1" hidden></option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}]
                                                    -
                                                    {{ $sanPham->tensanpham }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTangSua[]">
                                    <option value>Bỏ chọn sản phẩm 3
                                    </option>
                                    <option id="quaTangSua2" hidden></option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}]
                                                    -
                                                    {{ $sanPham->tensanpham }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTangSua[]">
                                    <option value>Bỏ chọn sản phẩm 4
                                    </option>
                                    <option id="quaTangSua3" hidden></option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}]
                                                    -
                                                    {{ $sanPham->tensanpham }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <select class="form-control" name="quaTangSua[]">
                                    <option value>Bỏ chọn sản phẩm 5
                                    </option>
                                    <option id="quaTangSua4" hidden></option>
                                    @if (!empty($danhSachSanPham))
                                        @foreach ($danhSachSanPham as $sanPham)
                                            @if ($sanPham->loaisanpham == 1)
                                                {{-- la phu kien --}}
                                                <option value="{{ $sanPham->masanpham }}">
                                                    [SP{{ $sanPham->masanpham }}]
                                                    -
                                                    {{ $sanPham->tensanpham }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Mô
                                    tả</label>
                                    <textarea id="moTaSua" name="moTaSua" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="maSanPhamSua" name="maSanPhamSua" value="0" type="number" hidden required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="sửa phụ kiện" class="btn btn-primary">Lưu</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal sua thong tin end-->
