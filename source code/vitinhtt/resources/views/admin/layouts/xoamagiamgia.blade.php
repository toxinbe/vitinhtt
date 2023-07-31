{{-- modal xoa start --}}
<div class="modal fade" id="xoaMaGiamGia" tabindex="-1" role="dialog" aria-hidden="true">
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
            <form action="{{ route('xulymagiamgia') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p id="noiDungXoa" class="small" style="font-size:14px !important;"></p>
                </div>
                <input id="maGiamGiaXoa" name="maGiamGiaXoa" pattern="[A-Za-z0-9]{3,50}" type="text" hidden required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button id="nutXoa" type="submit" name="thaoTac" value="xóa mã giảm giá" class="btn btn-danger">Đồng
                        ý</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- modal xoa end --}}
