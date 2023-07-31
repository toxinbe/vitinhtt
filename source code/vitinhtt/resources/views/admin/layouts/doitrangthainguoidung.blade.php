{{-- modal xoa start --}}
<div class="modal fade" id="doiTrangThaiNguoiDung" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold" id="tieuDeKhoa"></span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulynguoidung') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p id="noiDungKhoa" class="small" style="font-size:14px !important;"></p>
                </div>
                <input id="maNguoiDungKhoa" name="maNguoiDungKhoa" type="number" hidden required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" id="thaoTac" name="thaoTac" value="đổi trạng thái người dùng"
                        class="btn"></button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- modal xoa end --}}
