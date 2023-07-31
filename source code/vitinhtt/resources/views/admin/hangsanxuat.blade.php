@extends('admin.layouts.client')
@section('title')
    Hãng sản xuất
@endsection
@section('head')
    {{-- thêm css --}}
@endsection
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Hãng Sản Xuất</h2>
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
                                data-target="#themHangSanXuat">
                                <i class="fa fa-plus"></i>
                                &nbsp;Thêm Hãng
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.themhangsanxuat')
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">Mã</th>
                                        <th>Tên</th>
                                        <th width="15%">Loại</th>
                                        <th width="20%">Số sản phẩm thuộc hãng</th>
                                        <th width="25%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Tên</th>
                                        <th>Loại</th>
                                        <th>Số sản phẩm thuộc hãng</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($danhSachHangSanXuat))
                                        @foreach ($danhSachHangSanXuat as $hangSanXuat)
                                            <tr>
                                                <td>HSX{{ $hangSanXuat->mahang }}</td>
                                                <td>{{ $hangSanXuat->tenhang }}</td>
                                                <td>{{ $hangSanXuat->loaihang == 0 ? 'Laptop' : 'Phu Kiện' }}</td>
                                                <td>
                                                    @php
                                                        $soSanPhamThuocHang = 0;
                                                    @endphp
                                                    @if (!empty($danhSachSanPham))
                                                        @foreach ($danhSachSanPham as $sanPham)
                                                            @if ($sanPham->mahang == $hangSanXuat->mahang)
                                                                @php
                                                                    $soSanPhamThuocHang++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    {{ $soSanPhamThuocHang }}
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" data-toggle="modal" title="Xóa"
                                                            class="btn btn-link btn-danger" data-original-title="Xóa"
                                                            onclick="xoaHangSanXuat('{{ $hangSanXuat->tenhang }}','{{ $hangSanXuat->mahang }}','{{ $hangSanXuat->loaihang }}','{{ $soSanPhamThuocHang }}')"
                                                            data-target="#xoaHangSanXuat">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @include('admin.layouts.xoahangsanxuat')
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
@endsection
