{{-- modal xoa start --}}
<div class="modal fade" id="xoaLaptop" tabindex="-1" role="dialog" aria-hidden="true">
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
            <form action="{{ route('xulylaptop') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p id="noiDungXoa" class="small" style="font-size:14px !important;"></p>
                </div>
                <input id="maSanPhamXoa" name="maSanPhamXoa" type="number" hidden required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="xóa laptop" class="btn btn-danger">Đồng
                        ý</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- modal xoa end --}}
