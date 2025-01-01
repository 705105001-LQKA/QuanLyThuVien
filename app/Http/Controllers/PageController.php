<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phieu;
use App\Models\DocGia;
use App\Models\Sach;
use App\Models\LichSuMuonSach;

class PageController extends Controller
{
    public function index() {
        return view('index');
    }

    public function themDocGia() {
        return view('view_contents.quan-ly-doc-gia.them-doc-gia');
    }

    public function lichSuMuonSach(Request $request) {
        
        $sortOrder = $request->input('sortOrder', 'desc'); // Mặc định giảm dần
        $lichSus = LichSuMuonSach::orderBy('ngay_muon', $sortOrder)->get();
        
        return view('view_contents.lich-su-muon-sach.lich-su-muon-sach', compact('lichSus'),);
    }
}
