@extends('layouts.app')

@section('content')
    <div class="body">
        <div class="body-content">
            <div class="container form-container">
                <h4 class="mb-4 text-center">Lịch sử mượn sách</h4>

                {{-- <form method="GET" action="{{ route('sach.search') }}" id="search-book-form" class="input-group w-15">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </span>
                    <input type="text" name="search" placeholder="Tìm kiếm sách..." class="form-control">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form> --}}

                <div class="d-flex align-items-center mb-2">
                    <label for="filter-column" class="form-label me-2 w-15">Tìm kiếm theo:</label>
                    <select id="filter-column" class="form-select" style="width: 150px;">
                        <option value="all">Tất cả</option>
                        <option value="name">Họ và tên</option>
                        <option value="book">Tên sách</option>
                        <option value="borrow">Ngày mượn</option>
                        <option value="return">Ngày trả</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <label for="search-input" class="form-label me-2 w-15">Nhập từ khóa:</label>
                    <input type="text" id="search-input" class="form-control" placeholder="Tìm kiếm..." style="width: 50%;">
                    <button class="btn btn-primary" id="search-btn">Tìm kiếm</button>
                    <button class="btn btn-secondary" id="reset-btn">Xóa tìm kiếm</button>
                </div>                        
                
                <br><br>

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">
                                Họ và tên
                                <button class="btn btn-sm sort-btn" data-sort="name" data-order="asc">▲</button>
                            </th>
                            <th scope="col">Ngày sinh</th>
                            <th scope="col">Điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Mã sách</th>
                            <th scope="col">Tên sách</th>
                            <th scope="col">
                                Ngày mượn
                                <button class="btn btn-sm sort-btn" data-sort="date" data-order="asc">▲</button>
                            </th>
                            <th scope="col">Ngày trả</th>
                            <th scope="col">Quá hạn</th>
                            <th scope="col">Phí</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lichSus as $lichSu)
                            <tr data-id="{{ $lichSu->id }}">
                                <td class="ten-doc-gia">{{ $lichSu->ten_doc_gia}}</td>
                                <td class="ngay-sinh">{{ date('d/m/Y', strtotime($lichSu->nam_sinh)) }}</td>
                                <td class="dien-thoai">{{ $lichSu->dien_thoai }}</td>
                                <td class="dia-chi">{{ $lichSu->dia_chi }}</td>
                                <td class="ma-sach">{{ $lichSu->ma_sach }}</td>
                                <td class="ten-sach">{{ $lichSu->ten_sach }}</td>
                                <td class="ngay-muon">{{ date('d/m/Y', strtotime($lichSu->ngay_muon)) }}</td>
                                <td class="ngay-tra">{{ $lichSu->ngay_tra ? date('d/m/Y', strtotime($lichSu->ngay_tra)) : 'Chưa trả' }}</td>
                                <td class="qua_han"> {{ is_null($lichSu->qua_han) ? 'N/A' : ($lichSu->qua_han > 0 ? $lichSu->qua_han . ' ngày' : 'Không') }}</td>
                                <td class="phi"> {{ is_null($lichSu->phi) ? 'N/A' : ($lichSu->phi ? number_format($lichSu->phi, 0, ',', '.') . 'đ' : '0đ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.sort-btn').forEach(button => {
            button.addEventListener('click', () => {
                const tableBody = document.querySelector('tbody');
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                const sortBy = button.getAttribute('data-sort');
                const order = button.getAttribute('data-order');
                
                // Xác định cách sắp xếp
                rows.sort((a, b) => {
                    let valA, valB;

                    if (sortBy === 'name') {
                        // Sắp xếp theo họ tên
                        valA = a.querySelector('.ten-doc-gia').textContent.trim();
                        valB = b.querySelector('.ten-doc-gia').textContent.trim();
                    } else if (sortBy === 'date') {
                        // Sắp xếp theo ngày mượn
                        valA = new Date(a.querySelector('.ngay-muon').textContent.trim().split('/').reverse().join('-'));
                        valB = new Date(b.querySelector('.ngay-muon').textContent.trim().split('/').reverse().join('-'));
                    }

                    if (order === 'asc') {
                        return valA > valB ? 1 : -1;
                    } else {
                        return valA < valB ? 1 : -1;
                    }
                });

                // Đảo thứ tự sắp xếp
                button.setAttribute('data-order', order === 'asc' ? 'desc' : 'asc');

                // Cập nhật biểu tượng ▲ hoặc ▼
                button.textContent = order === 'asc' ? '▼' : '▲';

                // Render lại bảng
                rows.forEach(row => tableBody.appendChild(row));
            });
        });

        document.getElementById('search-btn').addEventListener('click', () => {
            const query = document.getElementById('search-input').value.toLowerCase();
            const filterColumn = document.getElementById('filter-column').value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.ten-doc-gia').textContent.toLowerCase();
                const bookName = row.querySelector('.ten-sach')?.textContent.toLowerCase();
                const borrowDate = row.querySelector('.ngay-muon').textContent.toLowerCase();
                const returnDate = row.querySelector('td:last-child').textContent.toLowerCase();

                let match = false;

                if (filterColumn === 'all') {
                    // Tìm kiếm toàn bảng
                    match = name.includes(query) || 
                            (bookName && bookName.includes(query)) || 
                            borrowDate.includes(query) || 
                            returnDate.includes(query);
                } else if (filterColumn === 'name') {
                    // Tìm kiếm theo Họ và tên
                    match = name.includes(query);
                } else if (filterColumn === 'book') {
                    // Tìm kiếm theo Tên sách
                    match = bookName && bookName.includes(query);
                } else if (filterColumn === 'borrow') {
                    // Tìm kiếm theo Ngày mượn
                    match = borrowDate.includes(query);
                } else if (filterColumn === 'return') {
                    // Tìm kiếm theo Ngày trả
                    match = returnDate.includes(query);
                }

                // Hiển thị hoặc ẩn dòng dựa trên kết quả tìm kiếm
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('reset-btn').addEventListener('click', () => {
            document.getElementById('search-input').value = '';
            document.getElementById('filter-column').value = 'all';

            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => row.style.display = ''); // Hiển thị tất cả các dòng
        });

    </script>
@endsection