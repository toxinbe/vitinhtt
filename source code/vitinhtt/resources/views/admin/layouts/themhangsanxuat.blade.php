<!-- Modal them mau moi start-->
<div class="modal fade" id="themHangSanXuat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Thêm hãng sản xuất mới</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulyhangsanxuat') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" style="font-size:14px !important;">Nhập thông tin theo mẫu bên dưới</p>
                    <div class="row">
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Tên hãng (*)</label>
                                <input name="tenHang" type="text" class="form-control"
                                    value="{{ old('tenHang') }}" onblur="doiTen(this)" required>
                                @error('tenHang')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Loại hãng (*)</label>
                                <select class="form-control" name="loaiHang" required>
                                    <option value="" selected hidden>Chọn ...</option>
                                    @if (old('loaiHang') != null)
                                        <option value="{{ old('loaiHang') }}" selected hidden>
                                            {{ old('loaiHang')==0?'Laptop':'Phụ kiện'}}</option>
                                    @endif
                                    <option value="0">Laptop</option>
                                    <option value="1" {{request()->is('phukien') ? 'selected' : ''}}>Phụ kiện</option>
                                </select>
                                @error('loaiHang')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="thêm hãng sản xuất" class="btn btn-primary">Thêm</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal them mau moi end-->
