<form action="{{ route('docgia.store') }}" method="POST">
    @csrf
    <div class="mb-4 p-3 table-container">
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="tenDocGia" class="form-label w-25 text-start">Tên độc giả:</label>
            <input type="text" class="form-control w-15" id="tenDocGiaMoi" name="ten_doc_gia">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="namSinh" class="form-label w-25 text-start">Năm sinh:</label>
            <input type="date" class="form-control w-15" id="namSinhMoi" name="nam_sinh">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="soCMND" class="form-label w-25 text-start">Số CMND:</label>
            <input type="text" class="form-control w-15" id="soCMND" name="cmnd">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="soDienThoai" class="form-label w-25 text-start">Số điện thoại:</label>
            <input type="text" class="form-control w-15" id="soDienThoaiMoi" name="dien_thoai">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="diaChi" class="form-label w-25 text-start">Địa chỉ:</label>
            <input type="text" class="form-control w-15" id="diaChiMoi" name="dia_chi">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="hanThe" class="form-label w-25 text-start">Hạn thẻ:</label>
            <input type="date" class="form-control w-15" id="hanTheMoi" name="han_the">
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary">Thêm</button>
    </div>
</form>
