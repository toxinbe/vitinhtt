<!-- Modal them mau moi start-->
<div class="modal fade" id="themLaptop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Thêm mẫu laptop mới</span>
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
                                    @if (!empty($danhSachHangSanXuatLaptop))
                                        @foreach ($danhSachHangSanXuatLaptop as $hangSanXuat)
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
                                <label style="font-size:12px !important;">CPU (*)</label>
                                <input name="cpu" type="text" class="form-control" value="{{ old('cpu') }}"
                                    required>
                                @error('cpu')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ram (GB) (*)</label>
                                <select class="form-control" name="ram" required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('ram') != null)
                                        <option value="{{ old('ram') }}" selected hidden>
                                            {{ old('ram') }} GB</option>
                                    @endif
                                    <option value="4">4 GB</option>
                                    <option value="8">8 GB</option>
                                    <option value="16">16 GB</option>
                                    <option value="32">32 GB</option>
                                </select>
                                @error('ram')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Card đồ họa (*)</label>
                                <select class="form-control" name="cardDoHoa" required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('cardDoHoa') != null)
                                        @if (old('cardDoHoa') == 0)
                                            <option value="{{ old('cardDoHoa') }}" selected hidden>
                                                Onboard</option>
                                        @elseif(old('cardDoHoa') == 1)
                                            <option value="{{ old('cardDoHoa') }}" selected hidden>
                                                Nvidia</option>
                                        @elseif(old('cardDoHoa') == 2)
                                            <option value="{{ old('cardDoHoa') }}" selected hidden>
                                                Amd</option>
                                        @endif
                                    @endif
                                    <option value="0">Onboard</option>
                                    <option value="1">Nvidia</option>
                                    <option value="2">Amd</option>
                                </select>
                                @error('cardDoHoa')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ổ cứng (GB) (*)</label>
                                <select class="form-control" name="oCung"required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('oCung') != null)
                                        <option value="{{ old('oCung') }}" selected hidden>
                                            {{ old('oCung') }} GB</option>
                                    @endif
                                    <option value="128">128 GB</option>
                                    <option value="256">256 GB</option>
                                    <option value="512">512 GB</option>
                                </select>
                                @error('oCung')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Màn hình (10 - 30 inch)
                                    (*)</label>
                                <input type="number" name="manHinh" class="form-control" step="0.1"
                                    value="{{ old('manHinh') }}" required>
                                @error('manHinh')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Nhu cầu (*)</label>
                                <select class="form-control" name="nhuCau" required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('nhuCau') != null)
                                        <option value="{{ old('nhuCau') }}" selected hidden>
                                            {{ old('nhuCau') }}</option>
                                    @endif
                                    <option value="Sinh Viên">Sinh Viên</option>
                                    <option value="Đồ Họa">Đồ Họa</option>
                                    <option value="Gaming">Gaming</option>
                                </select>
                                @error('nhuCau')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tình trạng (*)</label>
                                <select class="form-control" name="tinhTrang" required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('tinhTrang') != null)
                                        @if (old('tinhTrang') == 0)
                                            <option value="{{ old('tinhTrang') }}" selected hidden>
                                                Mới</option>
                                        @elseif(old('tinhTrang') == 1)
                                            <option value="{{ old('tinhTrang') }}" selected hidden>
                                                Cũ</option>
                                        @endif
                                    @endif
                                    <option value="0">Mới</option>
                                    <option value="1">Cũ</option>
                                </select>
                                @error('tinhTrang')
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
                    <button type="submit" name="thaoTac" value="thêm laptop" class="btn btn-primary">Thêm</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal them mau moi end-->
