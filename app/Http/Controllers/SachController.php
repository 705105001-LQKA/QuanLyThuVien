<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use Illuminate\Http\Request;

class SachController extends Controller
{
    public function quanLyKhoSach()
    {
        $sachs = Sach::all();
        return view('view_contents.quan-ly-kho-sach.quan-ly-kho-sach', compact('sachs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ma_sach' => 'required|string|max:255',
            'ten_sach' => 'required|string|max:255',
            'tac_gia' => 'required|string|max:255',
            'nha_xuat_ban' => 'required|string|max:255',
            'nam_xuat_ban' => 'required|date',
            'ngay_nhap' => 'required|date',
            'gia_tien'  => 'required|integer|max:55',
            'so_luong' => 'required|integer',
        ]);
        $validatedData['da_muon'] = 0;

        Sach::create($validatedData);

        return redirect()->route('quanLyKhoSach')->with('success', 'Sách đã được thêm thành công.');
    }

    public function show($id) {
        $sach = Sach::findOrFail($id);
        return response()->json($sach);
    }
    
    public function update(Request $request, $id) {
        $sach = Sach::findOrFail($id);
        $sach->update($request->all());
        return redirect()->route('quanLyKhoSach')->with('success', 'Cập nhật sách thành công!');
    }
    
    public function destroy($id)
    {
        $sach = Sach::findOrFail($id);
        $sach->delete();

        return redirect()->route('quanLyKhoSach')->with('success', 'Sách đã được xóa thành công.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            $sachs = Sach::all();
        } else {
            $sachs = Sach::where('ten_sach', 'LIKE', '%' . $search . '%')->get();
        }

        return view('view_contents.quan-ly-kho-sach.table-sach', compact('sachs'))->with('searchQuery', $search);
    }
}
