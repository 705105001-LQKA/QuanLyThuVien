<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Lấy tất cả dữ liệu từ bảng users
        return response()->json($users); // Trả về dạng JSON để dùng với API
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|integer',
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        // Trả về thông tin người dùng mới tạo
        return response()->json($user, 201);
    }

    public function edit($username)
    {
        // $user = User::findOrFail($id);
        // return view('users.edit', compact('user'));

        $user = User::where('username', $username)->firstOrFail();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $username)
    {
        // Validate input data
        // $request->validate([
        //     'username' => 'required|string|max:255',
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'role' => 'required|integer',
        // ]);

        // $user = User::findOrFail($id);
        // $user->username = $request->username;
        // $user->email = $request->email;
        // $user->password = bcrypt($request->password); // Hash the password
        // $user->role = $request->role;
        // $user->save();

        // return redirect()->route('users.index')->with('success', 'User updated successfully');

        // Tìm người dùng dựa trên username
        $user = User::where('username', $username)->firstOrFail();

        // Validate dữ liệu từ request
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'role' => 'required|integer'
        ]);

        // Cập nhật các thuộc tính của người dùng
        $user->username = $request->username;
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->role = $validatedData['role'];

        // Lưu người dùng
        $user->save();

        // Trả về phản hồi
        return response()->json(['message' => 'User updated successfully']);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

}
