<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocGia; // Model DocGia cần có để lưu dữ liệu
use Illuminate\Support\Facades\Log;


class DocGiaController extends Controller
{
    public function quanLyDocGia()
    {
        $docGias = DocGia::all();
        return view('view_contents.quan-ly-doc-gia.quan-ly-doc-gia', compact('docGias'));
    }

    public function show($id) {
        $docGia = DocGia::find($id);
        
        if ($docGia) {
            return response()->json($docGia);
        }
        
        return response()->json(['message' => 'Không tìm thấy độc giả.'], 404);
    }    
    
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'ten_doc_gia' => 'required|string|max:255',
            'nam_sinh' => 'required|date',
            'cmnd' => 'required|numeric',
            'dien_thoai' => 'required|numeric',
            'dia_chi' => 'required|string|max:255',
            'han_the' => 'required|date',
        ]);

        // Lưu dữ liệu vào database
        DocGia::create($validatedData);

        // Chuyển hướng hoặc trả về phản hồi thành công
        return redirect()->back()->with('success', 'Độc giả đã được thêm thành công!');
    }

    public function destroy($id) {
        $docGia = DocGia::find($id);
        
        if ($docGia) {
            $docGia->delete();
            return response()->json(['message' => 'Xóa độc giả thành công!'], 200);
        }
    
        return response()->json(['message' => 'Không tìm thấy độc giả.'], 404);
    }

    public function update(Request $request, $id)
    {
        $docGia = DocGia::findOrFail($id);
        $docGia->update($request->all());
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Tìm kiếm rỗng trả về toàn bộ độc giả
        if (empty($search)) {
            $docGias = DocGia::all();
        } else {
            $docGias = DocGia::where('ten_doc_gia', 'LIKE', '%' . $search . '%')->get();
        }

        return view('view_contents.quan-ly-doc-gia.table-doc-gia', compact('docGias'))->with('searchQuery', $search);
    }
}
