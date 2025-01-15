<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LichSuMuonSach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function thongKe(Request $request)
    {
        // Lấy dữ liệu tháng/năm từ request, nếu không có thì lấy tháng/năm hiện tại
        $monthByDay = $request->input('monthByDay', Carbon::now()->month);
        $yearByDay = $request->input('yearByDay', Carbon::now()->year);

        // Truy vấn top 5 sách được mượn nhiều nhất
        $topBooks = DB::table('lich_su_muon_sach')
            ->select('ma_sach', 'ten_sach', DB::raw('COUNT(*) as total'))
            ->groupBy('ma_sach', 'ten_sach')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Thống kê lượt mượn theo ngày trong tháng/năm được chọn
        $statsByDay = DB::table('lich_su_muon_sach')
            ->select(DB::raw('DATE(ngay_muon) as date'), DB::raw('COUNT(*) as borrow_count'))
            ->whereMonth('ngay_muon', $monthByDay)
            ->whereYear('ngay_muon', $yearByDay)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Thống kê lượt mượn theo từng tháng trong năm được chọn
        $statsByMonth = DB::table('lich_su_muon_sach')
            ->select(DB::raw('MONTH(ngay_muon) as month'), DB::raw('COUNT(*) as borrow_count'))
            ->whereYear('ngay_muon', $yearByDay)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Trả dữ liệu ra view
        return view('view_contents.thong-ke.thong-ke', compact('topBooks', 'statsByDay', 'statsByMonth'));
    }
}
