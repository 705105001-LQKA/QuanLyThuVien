<form action="{{ route('docgia.update', ['id' => $docGia->id ?? '']) }}" method="POST" id="editDocGiaForm">
    @csrf
    @method('PUT')
    <div class="mb-4 p-3 table-container">
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="tenDocGia" class="form-label w-25 text-start">Tên độc giả:</label>
            <input type="text" class="form-control w-15" id="editTenDocGia" name="ten_doc_gia">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="namSinh" class="form-label w-25 text-start">Năm sinh:</label>
            <input type="date" class="form-control w-15" id="editNamSinh" name="nam_sinh">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="soCMND" class="form-label w-25 text-start">Số CMND:</label>
            <input type="text" class="form-control w-15" id="editSoCMND" name="cmnd">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="soDienThoai" class="form-label w-25 text-start">Số điện thoại:</label>
            <input type="text" class="form-control w-15" id="editSoDienThoai" name="dien_thoai">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="diaChi" class="form-label w-25 text-start">Địa chỉ:</label>
            <input type="text" class="form-control w-15" id="editDiaChi" name="dia_chi">
        </div>
        <div class="mb-3 d-flex justify-content-evenly">
            <label for="hanThe" class="form-label w-25 text-start">Hạn thẻ:</label>
            <input type="date" class="form-control w-15" id="editHanThe" name="han_the">
        </div>
    </div>
    <input type="hidden" id="docGiaId" name="docGiaId">
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</form>
