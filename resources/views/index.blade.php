@extends('layouts.app')

@section('content')
    <div class="body" style="position: relative; height: 100vh; overflow: hidden;">
        <!-- Background Image -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;">
            <img src="{{ asset('images/library-background-4.jpeg') }}" 
                 alt="Library Background" 
                 style="width: 100%; height: 100%; object-fit: cover; filter: brightness(70%);">
        </div>

        <!-- Content -->
        <div class="d-flex justify-content-center align-items-center flex-column text-center" style="height: 100%;">
            <h1 class="text-white display-4 font-weight-bold">Chào mừng đến với Hệ thống Quản lý Thư viện</h1>
            <p class="text-white mt-3" style="font-size: 1.2rem;">
                Tại đây, bạn có thể quản lý sách, độc giả, phiếu mượn trả, và nhiều hơn thế nữa.
            </p>
        </div>
    </div>
@endsection
