@extends('layouts.app')

@section('content')
    <div class="body">
        <div class="body-content">
            <div class="container form-container">
                <h4 class="mb-4 mt-4 text-center">Quản lý độc giả</h4>

                <div class="input-group w-15">
                    <form method="GET" action="{{ route('docgia.search') }}" id="search-reader-form" class="input-group w-15">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </span>
                        <input type="text" name="search" placeholder="Tìm kiếm độc giả..." class="form-control">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>
                <br>

                <div class="mb-3 d-flex justify-content-between">
                    <button class="btn btn-primary w-20" onclick="$('#themDocGiaModal').modal('show')">Thêm độc giả</button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên độc giả</th>
                            <th scope="col">Năm sinh</th>
                            <th scope="col">CMND</th>
                            <th scope="col">Điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Hạn thẻ</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docGias as $index => $docGia)
                            <tr id="docGiaRow{{ $docGia->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $docGia->ten_doc_gia }}</td>
                                <td>{{ date('d/m/Y', strtotime($docGia->nam_sinh)) }}</td>
                                <td>{{ $docGia->cmnd }}</td>
                                <td>{{ $docGia->dien_thoai }}</td>
                                <td>{{ $docGia->dia_chi }}</td>
                                <td>{{ date('d/m/Y', strtotime($docGia->han_the)) }}</td>
                                <td>
                                    <button class="btn btn-sm" onclick="openEditModal('{{ $docGia->id }}'); $('#editDocGiaModal').modal('show')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-sm" onclick="deleteDocGia('{{ $docGia->id }}', '{{ $docGia->ten_doc_gia }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
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
    </div>

    <!-- Popup modal thêm độc giả -->
    <div class="modal fade" id="themDocGiaModal" tabindex="-1" role="dialog" aria-labelledby="themDocGiaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themDocGiaModalLabel">Thêm độc giả</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('view_contents.quan-ly-doc-gia.them-doc-gia')
                </div>
            </div>
        </div>
    </div>

    <!-- Popup modal sửa độc giả -->
    <div class="modal fade" id="editDocGiaModal" tabindex="-1" aria-labelledby="editDocGiaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDocGiaLabel">Sửa thông tin độc giả</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDocGiaForm">
                        <div class="modal-body">
                            @include('view_contents.quan-ly-doc-gia.sua-doc-gia')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchReaders(searchValue) {
            $.ajax({
                url: '{{ route('docgia.search') }}',
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
            $('#search-reader-form').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của form

                let searchValue = $('input[name="search"]').val(); // Lấy giá trị từ input tìm kiếm
                searchReaders(searchValue); // Gọi hàm tìm kiếm
            });
        });

        $('#editDocGiaForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            });
        });

        async function openEditModal(docGiaId) {
            try {
                // Cập nhật form action với docGiaId
                document.getElementById('editDocGiaForm').action = `/docgia/${docGiaId}`;

                // Fetch data từ server
                const response = await fetch(`/docgia/${docGiaId}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                // Cập nhật giá trị vào form
                document.getElementById('editTenDocGia').value = data.ten_doc_gia;
                document.getElementById('editNamSinh').value = data.nam_sinh;
                document.getElementById('editSoCMND').value = data.cmnd;
                document.getElementById('editSoDienThoai').value = data.dien_thoai;
                document.getElementById('editDiaChi').value = data.dia_chi;
                document.getElementById('editHanThe').value = data.han_the;
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Hàm xóa độc giả
        function deleteDocGia(id, tenDocGia) {
            // Hiển thị thông báo xác nhận
            if (confirm("Bạn có chắc chắn muốn xóa độc giả " + tenDocGia + " không?")) {
                $.ajax({
                    url: '/docgia/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // Thêm token CSRF
                    },
                    success: function(response) {
                        // Xử lý thành công
                        alert("Xóa độc giả thành công!");
                        location.reload(); // Tải lại trang hoặc cập nhật giao diện
                    },
                    error: function(xhr) {
                        // Xử lý lỗi
                        alert("Có lỗi xảy ra khi xóa độc giả.");
                        console.error(xhr.responseText); // Log thông tin lỗi
                    }
                });
            }
        }
    </script>
@endsection
