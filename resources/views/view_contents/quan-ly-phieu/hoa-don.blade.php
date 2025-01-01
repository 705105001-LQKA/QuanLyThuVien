<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn trả sách</title>
</head>
<body>
    <h1>Hóa đơn trả sách</h1>
    <p><strong>Mã phiếu:</strong> {{ $phieu->id }}</p>
    <p><strong>Tên độc giả:</strong> {{ $phieu->docGia->ten }}</p>
    <p><strong>Tên sách:</strong> {{ $phieu->sach->ten }}</p>
    <p><strong>Ngày mượn:</strong> {{ $phieu->ngay_muon }}</p>
    <p><strong>Ngày trả:</strong> {{ $phieu->ngay_tra }}</p>
    <p><strong>Số ngày quá hạn:</strong> {{ $lateDays }} ngày</p>
    <p><strong>Tình trạng sách:</strong> 
        @switch($condition)
            @case('normal') Sách bình thường @break
            @case('damaged') Sách bị hỏng @break
            @case('dirty') Sách bị bẩn @break
            @case('lost') Sách bị mất @break
            @default Không xác định
        @endswitch
    </p>
    <p><strong>Phí trả sách:</strong> {{ number_format($fee) }} VNĐ</p>
    <button onclick="window.print()">In hóa đơn</button>
</body>
</html>
