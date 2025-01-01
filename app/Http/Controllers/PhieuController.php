<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phieu;
use App\Models\DocGia;
use App\Models\Sach;
use App\Models\LichSuMuonSach;
use Carbon\Carbon;

class PhieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function quanLyPhieu()
    {
        $sachs = Sach::all();
        $docGias = DocGia::all();
        $phieus = Phieu::all();
        $docGias = DocGia::with('phieuMuon')->get();
        foreach ($docGias as $docGia) {
            if ($docGia->phieuMuon && $docGia->phieuMuon->ngay_tra && $docGia->phieuMuon->ngay_muon) {
                $ngayTra = Carbon::parse($docGia->phieuMuon->ngay_tra);
                $now = Carbon::now();
        
                // Tính số ngày quá hạn và phí
                $soNgayQuaHan = $now->greaterThan($ngayTra) ? $now->diffInDays($ngayTra) : 0;
                $phi = $soNgayQuaHan * 10000;
        
                // Cập nhật trực tiếp vào cơ sở dữ liệu
                $docGia->phieuMuon->update([
                    'qua_han' => $soNgayQuaHan,
                    'phi' => $phi,
                ]);
            }
        }
        // dd($docGias);
        // dd($phieus);
        return view('view_contents.quan-ly-phieu.phieu-muon-tra', compact('phieus'), compact('docGias'), compact('sachs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_gia_id' => 'required|exists:doc_gia,id',
            'ten_sach' => 'required|string',
            'ngay_muon' => 'required|date',
            'ngay_tra' => 'required|date',
        ]);

        // Kiểm tra nếu chưa chọn độc giả
        if (!$request->has('doc_gia_id') || empty($request->doc_gia_id)) {
            return back()->withErrors(['doc_gia_id' => 'Chưa chọn độc giả'])->withInput();
        }

        // Tìm sách theo tên
        $sach = Sach::where('ten_sach', $request->ten_sach)->first();

        if (!$sach) {
            return back()->with('error', 'Sách không tồn tại trong hệ thống.');
        } elseif ($sach->so_luong <= 0) {
            return redirect()->back()->with('error', "{$request->ten_sach} đã hết");
        }

        // Kiểm tra độc giả đã có phiếu mượn chưa
        $docGia = DocGia::find($request->input('doc_gia_id'));

        if (!is_null($docGia->id_phieu_muon)) {
            return redirect()->back()->with('error', 'Độc giả đã mượn sách.');
        }

        // Tạo phiếu mượn
        $phieuMuon = Phieu::create([
            'doc_gia_id' => $request->doc_gia_id,
            'sach_id' => $sach->id,
            'ngay_muon' => $request->ngay_muon,
            'ngay_tra' => $request->ngay_tra,
        ]);

        // Ghi vào bảng lịch sử
        LichSuMuonSach::create([
            'doc_gia_id' => $phieuMuon->doc_gia_id,
            'ten_doc_gia' => $phieuMuon->docGia->ten_doc_gia,
            'nam_sinh' => $phieuMuon->docGia->nam_sinh,
            'cmnd' => $phieuMuon->docGia->cmnd,
            'dien_thoai' => $phieuMuon->docGia->dien_thoai,
            'dia_chi' => $phieuMuon->docGia->dia_chi,
            'sach_id' => $phieuMuon->sach_id,
            'ten_sach' => $phieuMuon->sach->ten_sach,
            'ma_sach' => $phieuMuon->sach->ma_sach,
            'ngay_muon' => $phieuMuon->ngay_muon,
            'ngay_tra' => null,
            'qua_han' => null,
            'phi' => null,
        ]);

        // Cập nhật trường id_phieu_muon trong bảng doc_gia
        $docGia = DocGia::find($request->input('doc_gia_id'));
        $docGia->id_phieu_muon = $phieuMuon->id;
        $docGia->save();

        // Cập nhật số lượng sách: giảm 1
        $sach->so_luong -= 1;
        $sach->da_muon += 1;
        $sach->save();

        // Lưu ID của phiếu mượn vào session
        session(['phieuMuonId' => $phieuMuon->id]);

        return back()->with('success', 'Phiếu mượn được tạo thành công!');
    }

    public function inPhieu($id)
    {
        // Lấy phiếu mượn theo id
        $phieuMuon = Phieu::with('docGia', 'sach')->findOrFail($id);

        // Sau khi người dùng in phiếu, bạn có thể xóa session này:
        session()->forget('phieuMuonId');
        
        // Kiểm tra xem session với key 'user' đã bị xóa chưa
        // if (!session()->has('user')) {
        //     echo "Session 'user' đã bị xóa.";
        // }
        
        // Trả về view để in phiếu
        return view('view_contents.quan-ly-phieu.in', compact('phieuMuon'));
    }

    public function traSach(Request $request, $id)
    {
        try {
            // Lấy phiếu mượn
            $phieuMuon = Phieu::findOrFail($id);

            // Lấy thông tin ngày trả dự kiến và ngày mượn
            $ngayTraDuKien = Carbon::parse($phieuMuon->ngay_tra); // Ngày phải trả
            $ngayMuon = Carbon::parse($phieuMuon->ngay_muon); // Ngày mượn
            $ngayTraThucTe = Carbon::now('Asia/Ho_Chi_Minh'); // Ngày trả thực tế

            // Tính số ngày quá hạn
            $quaHan = 0;
            $phi = 0;

            // Giá trị từ radio button
            $condition = $request->input('condition');

            if ($ngayTraThucTe->greaterThan($ngayTraDuKien)) {
                $quaHan = $ngayTraThucTe->diffInDays($ngayTraDuKien); // Bao gồm ngày trả
                $phi = $quaHan * 10000; // Mỗi ngày quá hạn phí 10,000đ
            }

            switch ($condition) {
                case 'existent':
                    $phi += 20000;
                    break;
                case 'non-existent':
                    $phi += ($phieuMuon->sach->gia_tien)*3 + 20000;
                    break;
                case 'normal':
                    // Không cần phí nếu sách bình thường
                    break;
        
                default:
                    return response()->json(['success' => false, 'message' => 'Tình trạng sách không hợp lệ!']);
            }

            // Cập nhật ngày trả, quá hạn và phí trong bảng lịch sử
            LichSuMuonSach::where('doc_gia_id', $phieuMuon->doc_gia_id)
                ->where('sach_id', $phieuMuon->sach_id)
                ->whereNull('ngay_tra') // Chỉ cập nhật bản ghi chưa có ngày trả
                ->update([
                    'ngay_tra' => $ngayTraThucTe, // Ghi lại ngày trả
                    'qua_han' => $quaHan, // Số ngày quá hạn
                    'phi' => $phi, // Phí phạt
                ]);

            // Xóa phiếu mượn (nếu cần)
            $phieuMuon->delete();

            // Lấy thông tin sách từ phiếu mượn
            $sach = Sach::find($phieuMuon->sach_id);

            if ($sach) {
                // Tăng số lượng sách lên 1
                $sach->so_luong += 1;
                $sach->da_muon -= 1;
                $sach->save();
            }

            // Xóa id_phieu_muon trong bảng doc_gia
            $docGia = DocGia::find($phieuMuon->doc_gia_id);

            if ($docGia) {
                $docGia->id_phieu_muon = null;
                $docGia->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Trả sách thành công!',
                'phieu_id' => $phieuMuon->id,
                'condition' => $condition,
                'phi' => $phi,
                'qua_han' => $quaHan,
            ]);
        
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showHoaDon(Request $request)
    {
        $phieu = Phieu::find($request->query('phieu_id'));
        if (!$phieu) {
            return redirect()->back()->withErrors(['message' => 'Không tìm thấy phiếu mượn!']);
        }

        $condition = $request->query('condition');
        $phi = $request->query('phi');
        $quaHan = $request->query('qua_han');

        return view('hoa-don', [
            'phieu' => $phieu,
            'condition' => $condition,
            'phi' => $phi,
            'qua_han' => $quaHan
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');

        if (empty($keyword)) {
            return response()->json([]);
        }

        $sachs = Sach::where('ten_sach', 'LIKE', '%' . $keyword . '%')
            ->limit(10)
            ->get(['id', 'ten_sach']);

        return response()->json($sachs);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
