@extends('layouts.app')

@section('content')
    <div class="body">
        <div class="body-content">
            <div class="container form-container">
                <h4 class="mb-4 mt-4 text-center">Quản lý kho sách</h4>

                <form id="bookForm" action="{{ route('sach.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="bookId" name="book_id">
                    <div class="mb-4 p-3 table-container">
                        <div class="mb-3 d-flex ">
                            <label for="maSach" class="form-label w-15 text-start">Mã sách:</label>
                            <input type="text" class="form-control w-15" id="maSach" name="ma_sach">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="tenSach" class="form-label w-15 text-start">Tên sách:</label>
                            <input type="text" class="form-control w-15" id="tenSach" name="ten_sach">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="tacGia" class="form-label w-15 text-start">Tác giả:</label>
                            <input type="text" class="form-control w-15" id="tacGia" name="tac_gia">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="nhaXuatBan" class="form-label w-15 text-start">Nhà xuất bản:</label>
                            <input type="text" class="form-control w-15" id="nhaXuatBan" name="nha_xuat_ban">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="namXuatBan" class="form-label w-15 text-start">Năm xuất bản:</label>
                            <input type="date" class="form-control w-15" id="namXuatBan" name="nam_xuat_ban">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="ngayNhap" class="form-label w-15 text-start">Ngày nhập:</label>
                            <input type="date" class="form-control w-15" id="ngayNhap" name="ngay_nhap">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="giaTien" class="form-label w-15 text-start">Giá tiền:</label>
                            <input type="number" class="form-control w-15" id="giaTien" name="gia_tien">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="soLuong" class="form-label w-15 text-start">Số lượng:</label>
                            <input type="number" class="form-control w-15" id="soLuong" name="so_luong">
                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <button class="btn btn-primary w-20" type="submit">Thêm/Sửa sách</button>
                    </div>
                </form>
            </div>
            <div class="container form-container">
                <form method="GET" action="{{ route('sach.search') }}" id="search-book-form" class="input-group w-15">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </span>
                    <input type="text" name="search" placeholder="Tìm kiếm sách..." class="form-control">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Mã Sách</th>
                            <th scope="col">Tên Sách</th>
                            <th scope="col">Tác Giả</th>
                            <th scope="col">NXB</th>
                            <th scope="col">Giá tiền</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Đã mượn</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sachs as $index => $sach)
                        <tr id="sachRow{{ $sach->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sach->ma_sach }}</td>
                            <td>{{ $sach->ten_sach }}</td>
                            <td>{{ $sach->tac_gia }}</td>
                            <td>{{ $sach->nha_xuat_ban }}</td>
                            <td>{{ $sach->gia_tien }}đ</td>
                            <td>{{ $sach->so_luong }}</td>
                            <td>{{ $sach->da_muon }}</td>
                            <td>
                                <button class="btn btn-sm" onclick="editSach('{{ $sach->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>
                                <button class="btn btn-sm" onclick="deleteSach('{{ $sach->id }}', '{{ $sach->ten_sach }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchBooks(searchValue) {
            $.ajax({
                url: '{{ route('sach.search') }}',
                method: 'GET',
                data: {
                    search: searchValue
                },
                success: function(response) {
                    $('tbody').html(response);
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        $(document).ready(function() {
            $('#search-book-form').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của form

                let searchValue = $('input[name="search"]').val(); // Lấy giá trị từ input tìm kiếm
                searchBooks(searchValue); // Gọi hàm tìm kiếm
            });
        });

        function editSach(id) {
            $.ajax({
                url: `/sach/${id}`,  // Đường dẫn tới API lấy thông tin sách
                type: 'GET',
                success: function(response) {
                    // Điền thông tin sách vào form
                    $('#bookId').val(response.id);
                    $('#maSach').val(response.ma_sach);
                    $('#tenSach').val(response.ten_sach);
                    $('#tacGia').val(response.tac_gia);
                    $('#nhaXuatBan').val(response.nha_xuat_ban);
                    $('#namXuatBan').val(response.nam_xuat_ban);
                    $('#ngayNhap').val(response.ngay_nhap);
                    $('#giaTien').val(response.gia_tien);
                    $('#soLuong').val(response.so_luong);

                    // Chuyển nút submit thành "Cập nhật sách"
                    $('#submitBtn').text('Cập nhật sách');

                    // Thay đổi hành động form cho cập nhật
                    $('#bookForm').attr('action', `/sach/${id}`);
                    $('#bookForm').append('<input type="hidden" name="_method" value="PUT">');
                },
                error: function(xhr) {
                    alert("Có lỗi xảy ra khi lấy thông tin sách.");
                    console.error(xhr.responseText);
                }
            });
        }

        function deleteSach(id, tenSach) {
            if (confirm("Bạn có chắc chắn muốn xóa sách " + tenSach + " không?")) {
                $.ajax({
                    url: '/sach/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        alert("Xóa sách thành công!");
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Có lỗi xảy ra khi xóa sách.");
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>
@endsection
