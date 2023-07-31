{{-- modal xoa start --}}
<div class="modal fade" id="xoaPhieuXuat{{ $phieuXuat->maphieuxuat }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Bạn có thực sự muốn xóa?</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulyphieuxuat') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" style="font-size:14px !important;">
                        Thao
                        tác này sẽ xóa phiếu xuất
                        [PX{{ $phieuXuat->maphieuxuat }}] vĩnh viễn và
                        không thể khôi phục lại, nên cân nhắc
                        trước khi xóa</p>
                </div>
                <input name="maPhieuXuatXoa" type="number" hidden value="{{ $phieuXuat->maphieuxuat }}" required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="xóa phiếu xuất" class="btn btn-danger">Đồng
                        ý</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- modal xoa end --}}
