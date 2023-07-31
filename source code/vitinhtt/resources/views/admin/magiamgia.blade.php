@extends('admin.layouts.client')
@section('title')
    Mã giảm giá
@endsection
@section('head')
    {{-- thêm css --}}
@endsection
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Mã Giảm Giá</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row mt--2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh sách</h4>
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                data-target="#themMaGiamGia">
                                <i class="fa fa-plus"></i>
                                &nbsp;Thêm Mã Giảm Giá
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.themmagiamgia')
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">Mã</th>
                                        <th width="13%">Ngày bắt đầu</th>
                                        <th width="13%">Ngày kết thúc</th>
                                        <th>Mô tả</th>
                                        <th width="11%">Số đơn đã áp dụng</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="12%">Số tiền giảm</th>
                                        <th width="10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Mô tả</th>
                                        <th>Số đơn đã áp dụng</th>
                                        <th>Trạng thái</th>
                                        <th>Số tiền giảm</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($danhSachMaGiamGia))
                                        @foreach ($danhSachMaGiamGia as $maGiamGia)
                                            {{-- la nguoidung --}}
                                            <tr>
                                                <td>{{ $maGiamGia->magiamgia }}</td>
                                                <td>{{ date('d/m/Y', strtotime($maGiamGia->ngaybatdau)) }}</td>
                                                <td>{{ date('d/m/Y', strtotime($maGiamGia->ngayketthuc)) }}</td>
                                                @php
                                                    $moTa = $maGiamGia->mota;
                                                    if (!empty($moTa)) {
                                                        $soLuongKyTu = strlen($moTa);
                                                        $tam = '';
                                                        $demTu = 0;
                                                        for ($j = 0; $j < $soLuongKyTu; $j++) {
                                                            if ($moTa[$j] == ' ' && $demTu < 9) {
                                                                $demTu++;
                                                            } elseif ($demTu == 9) {
                                                                $tam[$j] = '.';
                                                                $tam[$j + 1] = '.';
                                                                $tam[$j + 2] = '.';
                                                                break;
                                                            }
                                                            $tam[$j] = $moTa[$j];
                                                        }
                                                        $moTa = $tam;
                                                        echo '<td class="cantrai" title="'.$maGiamGia->mota.'">' . $moTa . '</td>';
                                                    } else {
                                                        echo '<td></td>';
                                                    }
                                                @endphp
                                                <td>
                                                    @php
                                                        $soDonDaApDung = 0;
                                                    @endphp
                                                    @if (!empty($danhSachPhieuXuat))
                                                        @foreach ($danhSachPhieuXuat as $phieuXuat)
                                                            @if ($phieuXuat->magiamgia == $maGiamGia->magiamgia)
                                                                @php
                                                                    $soDonDaApDung++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    {{ $soDonDaApDung }}
                                                </td>
                                                <td>
                                                    @if (strtotime($maGiamGia->ngayketthuc) - strtotime(date('Y-m-d')) >= 0)
                                                        <button type="button" class="btn btn-success btn-border"
                                                            onclick='suaMaGiamGia({!! json_encode($maGiamGia) !!},false)'
                                                            data-toggle="modal" title="Đổi trạng thái"
                                                            data-original-title="Đổi trạng thái" style="width:99%;"
                                                            data-target="#suaMaGiamGia">Còn hạn
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-danger btn-border"
                                                            onclick='suaMaGiamGia({!! json_encode($maGiamGia) !!},true)'
                                                            data-toggle="modal" title="Đổi trạng thái"
                                                            data-original-title="Đổi trạng thái" style="width:99%;"
                                                            data-target="#suaMaGiamGia">Hết hạn
                                                        </button>
                                                    @endif
                                                </td>
                                                <td class="canphai">{{ number_format($maGiamGia->sotiengiam, 0, ',') }}
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" data-toggle="modal" title="Xóa"
                                                            class="btn btn-link btn-danger" data-original-title="Xóa"
                                                            onclick="xoaMaGiamGia('{{ $maGiamGia->magiamgia }}','{{ $soDonDaApDung }}')"
                                                            data-target="#xoaMaGiamGia">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @include('admin.layouts.suamagiamgia')
                                        @include('admin.layouts.xoamagiamgia')
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
    <script>
        $(document).ready(function() {
            $('#hetHanCheck').change(function() {
                var hetHanCheck = document.getElementById('hetHanCheck');
                if (hetHanCheck.checked) {
                    $('#divNgayBatDau').addClass('displaynone');
                    $('#divNgayKetThuc').addClass('displaynone');
                    document.getElementById('ngayBatDauSua').required = false;
                    document.getElementById('ngayKetThucSua').required = false;
                } else {
                    $('#divNgayBatDau').removeClass('displaynone');
                    $('#divNgayKetThuc').removeClass('displaynone');
                    document.getElementById('ngayBatDauSua').required = true;
                    document.getElementById('ngayKetThucSua').required = true;
                }
            });

        });
    </script>
@endsection
