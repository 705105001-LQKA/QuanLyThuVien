@extends('layouts.app')

@section('content')
    <div class="body">
        <div class="body-content">
            <div class="container form-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Kiểm tra lỗi "Chưa chọn độc giả" --}}
                @if ($errors->has('doc_gia_id'))
                    <div class="alert alert-danger">
                        Chưa chọn độc giả!
                    </div>
                @endif
                <h4 class="mb-4 text-center">Phiếu mượn sách</h4>

                <form action="{{ route('phieu.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="doc_gia_id" id="docGiaId">
                    <div class="mb-4 p-3 table-container">
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="tenDocGia" class="form-label w-15 text-start">Họ và tên:</label>
                            <input type="text" class="form-control w-15" id="tenDocGia" readonly>
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="soCMND" class="form-label w-15 text-start">Số CMND:</label>
                            <input type="text" class="form-control w-15" id="soCMND" readonly>
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="sachMuon" class="form-label w-15 text-start">Sách mượn:</label>
                            <input type="text" class="form-control w-15" id="sachMuon" name="ten_sach">
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="ngayMuon" class="form-label w-15 text-start">Ngày mượn:</label>
                            <input type="date" class="form-control w-15" id="ngayMuon" name="ngay_muon" readonly>
                        </div>
                        <div class="mb-3 d-flex justify-content-evenly">
                            <label for="ngayTra" class="form-label w-15 text-start">Ngày phải trả:</label>
                            <input type="date" class="form-control w-15" id="ngayTra" name="ngay_tra" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mb-4">
                        <button type="reset" class="btn btn-light me-3">Hủy</button>
                        <button type="submit" class="btn btn-primary">Tạo phiếu</button>
                    </div>
                </form>

                @if (session('phieuMuonId'))
                    <a href="{{ route('phieu.in', ['id' => session('phieuMuonId')]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-printer"></i> In Phiếu
                    </a>
                    <br><br><br>
                @endif

            </div>
            <div class="container form-container">

                <div class="d-flex align-items-center mb-2">
                    <label for="filter-column" class="form-label me-2 w-15">Tìm kiếm theo:</label>
                    <select id="filter-column" class="form-select" style="width: 150px;">
                        <option value="all">Tất cả</option>
                        <option value="name">Họ và tên</option>
                        <option value="book">Tên sách</option>
                        <option value="borrow">Ngày mượn</option>
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
                            <th scope="col">Họ và tên</th>
                            <th scope="col">CMND</th>
                            <th scope="col">Mã phiếu</th>
                            <th scope="col">Tên sách</th>
                            <th scope="col">Giá tiền</th>
                            <th scope="col">Ngày mượn</th>
                            <th scope="col">Ngày phải trả</th>
                            <th scope="col">Quá hạn</th>
                            <th scope="col">Phí</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docGias as $docGia)
                            <tr data-id="{{ $docGia->id }}">
                                <td class="ten-doc-gia">{{ $docGia->ten_doc_gia }}</td>
                                <td class="cmnd">{{ $docGia->cmnd }}</td>
                                <td class="ma-phieu">{{ $docGia->phieuMuon ? $docGia->phieuMuon->id : 'Chưa có phiếu' }}</td>
                                <td class="ten-sach">{{ $docGia->phieuMuon && $docGia->phieuMuon->sach ? $docGia->phieuMuon->sach->ten_sach : 'Chưa chọn sách' }}</td>
                                <td class="gia-tien">{{ $docGia->phieuMuon && $docGia->phieuMuon->sach ? number_format($docGia->phieuMuon->sach->gia_tien, 0, ',', '.') . 'đ' : 'Chưa chọn' }}</td>
                                <td class="ngay-muon">{{ $docGia->phieuMuon ? date('d/m/Y', strtotime($docGia->phieuMuon->ngay_muon)) : 'Chưa mượn' }}</td>
                                <td class="ngay-tra">{{ $docGia->phieuMuon ? date('d/m/Y', strtotime($docGia->phieuMuon->ngay_tra)) : 'Chưa mượn' }}</td>
                                <td class="qua-han">{{ $docGia->phieuMuon ? ($docGia->phieuMuon->qua_han > 0 ? $docGia->phieuMuon->qua_han . ' ngày' : 'Không') : 'N/A' }}</td>
                                <td class="phi">{{ $docGia->phieuMuon && $docGia->phieuMuon->phi > 0 ? number_format($docGia->phieuMuon->phi, 0, ',', '.') . 'đ' : '0đ' }}</td>
                                <td>
                                    <button class="btn btn-sm" onclick="addPhieu('{{ $docGia->id }}')" @if ($docGia->phieuMuon) disabled @endif>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5z"/>
                                        </svg>
                                    </button>
                                    <button class="btn btn-sm" onclick="confirmReturn('{{ $docGia->ten_doc_gia }}', '{{ optional($docGia->phieuMuon)->id }}', '{{ $docGia->phieuMuon->qua_han ?? 0 }}', '{{ $docGia->phieuMuon->sach->gia_tien ?? 0 }}')" @if (!$docGia->phieuMuon) disabled @endif data-bs-toggle="modal" data-bs-target="#returnModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bookmark-dash-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M6 6a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
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

    <!-- Modal xác nhận -->
    <div class="modal fade" id="confirmReturnModal" tabindex="-1" aria-labelledby="confirmReturnLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmReturnLabel">Xác nhận trả sách</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <!-- Input ẩn chứa phieuMuonId -->
                        <input type="hidden" id="phieuMuonIdHidden" name="phieuMuonId">
                        <p id="modalMessage"></p>                        

                        <div class="mb-3">
                            <label for="bookCondition" class="form-label">Tình trạng sách:</label>
                            <div>
                                <input type="radio" id="normal" name="bookCondition" value="normal" onclick="updateFee('normal')">
                                <label for="normal">Sách bình thường</label>
                            </div>
                            <div>
                                <input type="radio" id="existent" name="bookCondition" value="existent" onclick="updateFee('existent')">
                                <label for="existent">Sách bị hỏng có trên thị trường</label>
                            </div>
                            <div>
                                <input type="radio" id="non-existent" name="bookCondition" value="non-existent" onclick="updateFee('non-existent')">
                                <label for="non-existent">Sách bị hỏng không có trên thị trường</label>
                            </div>
                        </div>                  
                        
                        <div>
                            <h4>Lưu ý:</h4>
                            <div> - Mượn sách quá thời hạn sẽ tính 10,000đ/ngày.</div>
                            <div> - Làm bẩn, hỏng, mất sách đang phát hành trên thị trường sẽ phải bồi thường tài liệu mới đúng tên tài liệu, tên tác giả, năm xuất bản mới hơn + 20,000đ phí xử lý kỹ thuật.</div>
                            <div> - Làm bẩn, hỏng, mất sách không phát hành trên thị trường sẽ phải bồi thường bằng gấp 3 lần giá tiền + 20,000đ phí xử lý kỹ thuật.</div>
                        </div>
                        <br>
                        
                        <div class="mb-3">
                            <h4 class="form-label">Thông tin:</h4>
                            <ul>
                                <p>Số ngày quá hạn: <span id="overdue-days"></span></p>
                                <p>Giá sách: <span id="book-price"></span></p>
                                <p>Phí: <span id="totalFee"></span></p>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                    <button type="button" class="btn btn-primary" id="confirmYesButton">Có</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPhieu(docGiaId) {
            // Lấy hàng tương ứng với docGiaId
            const docGiaRow = document.querySelector(`tr[data-id="${docGiaId}"]`);

            if (docGiaRow) {
                // Gán giá trị vào form
                document.getElementById('docGiaId').value = docGiaId;
                document.getElementById('tenDocGia').value = docGiaRow.querySelector('.ten-doc-gia').textContent.trim();
                document.getElementById('soCMND').value = docGiaRow.querySelector('.cmnd').textContent.trim();

                // Reset sách mượn và gán ngày mượn
                const now = new Date();
                const localDate = now.toLocaleDateString('en-CA');
                document.getElementById('sachMuon').value = '';
                document.getElementById('ngayMuon').value = localDate;

                // Gán ngày trả
                const future = new Date();
                future.setDate(now.getDate() + 7);
                const returnBookDate = future.toLocaleDateString('en-CA');
                document.getElementById('ngayTra').value = returnBookDate;
            }
        }

        let overdueDaysGlobal = 0;
        let bookPriceGlobal = 0;

        function updateFee(condition) {
            const lateFee = overdueDaysGlobal * 10000;
            const technicalFee = 20000;

            let totalFee = 0;

            if (condition === 'normal') {
                totalFee = lateFee;
            } else if (condition === 'existent') {
                totalFee = lateFee + bookPriceGlobal * 1 + technicalFee;
            } else if (condition === 'non-existent') {
                totalFee = lateFee + bookPriceGlobal * 3 + technicalFee;
            }

            bookPriceGlobal = bookPriceGlobal * 1;

            // Cập nhật thông tin phí và ngày quá hạn
            document.getElementById('overdue-days').textContent = overdueDaysGlobal;
            document.getElementById('book-price').textContent = bookPriceGlobal ? bookPriceGlobal.toLocaleString() : 0;
            document.getElementById('totalFee').textContent = totalFee ? totalFee.toLocaleString() : 0;
        }

        function confirmReturn(docGiaName, phieuMuonId, overdueDays, bookPrice, condition) {
            // Lưu giá trị overdueDays và bookPrice vào biến toàn cục
            overdueDaysGlobal = overdueDays;
            bookPriceGlobal = bookPrice;

            // Cập nhật nội dung modal
            document.getElementById('modalMessage').innerText = `Độc giả ${docGiaName} muốn trả sách không?`;

            // Gắn phieuMuonId vào input ẩn cho modal
            document.getElementById('phieuMuonIdHidden').value = phieuMuonId;

            // Cập nhật thông tin phí
            updateFee(condition); // Mặc định sử dụng điều kiện sách được truyền vào

            // Chọn radio button đúng theo điều kiện
            const bookConditionInputs = document.querySelectorAll('input[name="bookCondition"]');
            bookConditionInputs.forEach(input => {
                input.checked = false;  // Bỏ chọn tất cả radio buttons
            });

            // Chọn radio button theo condition
            if (condition === 'normal') {
                document.getElementById('normal').checked = true;
            } else if (condition === 'existent') {
                document.getElementById('existent').checked = true;
            } else if (condition === 'non-existent') {
                document.getElementById('non-existent').checked = true;
            }

            // Gắn sự kiện cho nút 'Có'
            const confirmButton = document.getElementById('confirmYesButton');
            confirmButton.onclick = function() {
                handleReturn(phieuMuonId);
            };

            // Hiển thị modal
            const modal = new bootstrap.Modal(document.getElementById('confirmReturnModal'));
            modal.show();
        }

        function handleReturn(phieuMuonId) {
            const bookCondition = document.querySelector('input[name="bookCondition"]:checked');

            if (!bookCondition) {
                alert("Vui lòng chọn tình trạng sách trước khi xác nhận!");
                return;
            }

            const conditionValue = bookCondition.value;
            // Gửi AJAX yêu cầu trả sách
            fetch(`/quan-ly-phieu/${phieuMuonId}/tra-sach`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    condition: conditionValue,
                    phieu_id: phieuMuonId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // console.log(data);
                    // Reload lại trang hoặc cập nhật giao diện
                    // const url = `/quan-ly-phieu/hoa-don?phieu_id=${data.phieu_id}&condition=${conditionValue}&phi=${data.phi}&qua_han=${data.quaHan}`;
                    // window.location.href = url;
                    window.location.reload();
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            })
            .catch(error => console.error('Lỗi:', error));
        }

        document.getElementById('search-btn').addEventListener('click', () => {
            const query = document.getElementById('search-input').value.toLowerCase();
            const filterColumn = document.getElementById('filter-column').value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.ten-doc-gia').textContent.toLowerCase();
                const bookName = row.querySelector('.ten-sach')?.textContent.toLowerCase();
                const borrowDate = row.querySelector('.ngay-muon').textContent.toLowerCase();

                let match = false;

                if (filterColumn === 'all') {
                    // Tìm kiếm toàn bảng
                    match = name.includes(query) || 
                            (bookName && bookName.includes(query)) || 
                            borrowDate.includes(query);
                } else if (filterColumn === 'name') {
                    // Tìm kiếm theo Họ và tên
                    match = name.includes(query);
                } else if (filterColumn === 'book') {
                    // Tìm kiếm theo Tên sách
                    match = bookName && bookName.includes(query);
                } else if (filterColumn === 'borrow') {
                    // Tìm kiếm theo Ngày mượn
                    match = borrowDate.includes(query);
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

        document.addEventListener('DOMContentLoaded', function () {
            const sachInput = document.getElementById('sachMuon');
            const suggestionBox = document.createElement('ul');
            suggestionBox.style.position = 'absolute';
            suggestionBox.style.border = '1px solid #ddd';
            suggestionBox.style.backgroundColor = '#fff';
            suggestionBox.style.listStyleType = 'none';
            suggestionBox.style.padding = '0';
            suggestionBox.style.margin = '0';
            suggestionBox.style.zIndex = '1000';
            suggestionBox.style.width = sachInput.offsetWidth + 'px';
            document.body.appendChild(suggestionBox);

            sachInput.addEventListener('input', function () {
                const query = this.value;

                if (query.length < 1) {
                    suggestionBox.innerHTML = '';
                    return;
                }

                fetch(`/quan-ly-phieu/sach/search?q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionBox.innerHTML = '';
                        data.forEach(book => {
                            const item = document.createElement('li');
                            item.textContent = book.ten_sach;
                            item.style.padding = '8px';
                            item.style.cursor = 'pointer';

                            item.addEventListener('click', function () {
                                sachInput.value = book.ten_sach;
                                suggestionBox.innerHTML = '';
                            });

                            suggestionBox.appendChild(item);
                        });
                    })
                    .catch(error => console.error('Error fetching books:', error));
            });

            sachInput.addEventListener('focus', function () {
                const rect = sachInput.getBoundingClientRect();
                suggestionBox.style.top = `${rect.bottom + window.scrollY}px`;
                suggestionBox.style.left = `${rect.left + window.scrollX}px`;
            });

            sachInput.addEventListener('blur', function () {
                setTimeout(() => suggestionBox.innerHTML = '', 100); // Đợi một chút trước khi ẩn để chọn được item
            });
        });
    </script>
@endsection