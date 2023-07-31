<!-- Modal sua thong tin start-->
<div class="modal fade" id="suaLaptop" tabindex="-1" role="dialog" aria-hidden="true">
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
            <form action="{{ route('xulylaptop') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" style="font-size:14px !important;">Nhập thông tin theo mẫu bên dưới</p>
                    <div class="row">
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tên
                                    sản phẩm (*)</label>
                                <input id="tenSanPhamSua" name="tenSanPhamSua" type="" class="form-control"
                                    required>
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
                                    <option id="hangSanXuatSua" selected hidden>
                                    </option>
                                    @if (!empty($danhSachHangSanXuatLaptop))
                                        @foreach ($danhSachHangSanXuatLaptop as $hangSanXuat_Sua)
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
                                <label style="font-size:12px !important;">CPU
                                    (*)
                                </label>
                                <input name="cpuSua" id="cpuSua" type="text" class="form-control" required>
                                @error('cpuSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ram
                                    (GB) (*)</label>
                                <select class="form-control" name="ramSua" required>
                                    <option id="ramSua" selected hidden></option>
                                    <option value="4">4 GB
                                    </option>
                                    <option value="8">8 GB
                                    </option>
                                    <option value="16">16
                                        GB
                                    </option>
                                    <option value="32">32
                                        GB
                                    </option>
                                </select>
                                @error('ramSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Card
                                    đồ họa (*)</label>
                                <select class="form-control" name="cardDoHoaSua" required>
                                    <option id="cardDoHoaSua" selected hidden></option>
                                    <option value="0">
                                        Onboard
                                    </option>
                                    <option value="1">
                                        Nvidia
                                    </option>
                                    <option value="2">Amd
                                    </option>
                                </select>
                                @error('cardDoHoaSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ổ
                                    cứng (GB) (*)</label>
                                <select class="form-control" name="oCungSua" required>
                                    <option id="oCungSua" selected hidden></option>
                                    <option value="128">128
                                        GB
                                    </option>
                                    <option value="256">256
                                        GB
                                    </option>
                                    <option value="512">512
                                        GB
                                    </option>
                                </select>
                                @error('oCungSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Màn
                                    hình (10 - 30 inch)
                                    (*)
                                </label>
                                <input type="number" name="manHinhSua" id="manHinhSua" class="form-control"
                                    step="0.1" required>
                                @error('manHinhSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Nhu
                                    cầu (*)</label>
                                <select class="form-control" name="nhuCauSua" required>
                                    <option id="nhuCauSua" selected hidden></option>
                                    <option value="Sinh Viên">
                                        Sinh Viên
                                    </option>
                                    <option value="Đồ Họa">Đồ
                                        Họa</option>
                                    <option value="Gaming">
                                        Gaming</option>
                                </select>
                                @error('nhuCauSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tình
                                    trạng (*)</label>
                                <select class="form-control" name="tinhTrangSua" required>
                                    <option id="tinhTrangSua" selected hidden></option>
                                    <option value="0">Mới
                                    </option>
                                    <option value="1">Cũ
                                    </option>
                                </select>
                                @error('tinhTrangSua')
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
                <input id="maSanPhamSua" name="maSanPhamSua" type="number" hidden value="0" required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="sửa laptop" class="btn btn-primary">Lưu</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
    <!-- Modal sua thong tin end-->
</div>
