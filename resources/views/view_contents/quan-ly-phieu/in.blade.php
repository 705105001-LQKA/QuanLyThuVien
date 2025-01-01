<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Phiếu Mượn</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>     --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Thêm một số kiểu CSS cho trang in */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
        .btn-print {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        @media print {
            .btn-print, .btn-back {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="btn btn-sm btn-back" onclick="goBackWithReload()">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-backspace" viewBox="0 0 16 16">
            <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
            <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
        </svg>
    </button>
    <div class="container">
        <div class="header">
            <h2>Phiếu Mượn Sách</h2>
            <p>Ngày mượn: {{ date('d/m/Y', strtotime($phieuMuon->ngay_muon)) }}</p>
        </div>

        <table class="table">
            <tr>
                <th>Họ và tên</th>
                <td>{{ $phieuMuon->docGia->ten_doc_gia }}</td>
            </tr>
            <tr>
                <th>Ngày sinh</th>
                <td>{{ date('d/m/Y', strtotime($phieuMuon->docGia->nam_sinh)) }}</td>
            </tr>
            <tr>
                <th>Số CMND</th>
                <td>{{ $phieuMuon->docGia->cmnd }}</td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>{{ $phieuMuon->docGia->dien_thoai }}</td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>{{ $phieuMuon->docGia->dia_chi }}</td>
            </tr>
            <tr>
                <th>Tên sách</th>
                <td>{{ $phieuMuon->sach->ten_sach }}</td>
            </tr>
            <tr>
                <th>Giá tiền</th>
                <td>{{ number_format($phieuMuon->sach->gia_tien, 0, ',', '.') . ' VNĐ' }}</td>
            </tr>
            <tr>
                <th>Ngày mượn</th>
                <td>{{ date('d/m/Y', strtotime($phieuMuon->ngay_muon)) }}</td>
            </tr>
            <tr>
                <th>Ngày phải trả</th>
                <td>{{ date('d/m/Y', strtotime($phieuMuon->ngay_tra)) }}</td>
            </tr>
        </table>

        <div>
            <h4>Lưu ý:</h4>
            <div> - Mượn sách quá thời hạn sẽ tính 10,000đ/ngày.</div>
            <div> - Làm bẩn, hỏng, mất sách đang phát hành trên thị trường sẽ phải bồi thường tài liệu mới đúng tên tài liệu, tên tác giả, năm xuất bản mới hơn + 20,000đ phí xử lý kỹ thuật.</div>
            <div> - Làm bẩn, hỏng, mất sách không phát hành trên thị trường sẽ phải bồi thường bằng gấp 3 lần giá tiền + 20,000đ phí xử lý kỹ thuật.</div>
        </div>

        <div class="footer">
            <button class="btn-print" onclick="window.print()">In Phiếu</button>
        </div>
    </div>

    <script>
        function goBackWithReload() {
            window.location.href = document.referrer || '/';
        }
    </script>
</body>
</html>
