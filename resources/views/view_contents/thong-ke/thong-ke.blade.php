@extends('layouts.app')

@section('content')
    <div class="body">
        <div class="body-content">
            <div class="container form-container">
                <h4 class="mb-4 text-center">Thống kê top 5 sách được mượn nhiều nhất</h4>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã sách</th>
                            <th>Tên sách</th>
                            <th>Số lượt mượn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topBooks as $index => $book)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $book->ma_sach }}</td>
                                <td>{{ $book->ten_sach }}</td>
                                <td>{{ $book->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <!-- Biểu đồ lượt mượn theo ngày -->
            <div class="container form-container">
                <h4 class="mb-4 text-center">Thống kê lượt mượn sách theo ngày</h4>
                <canvas id="borrowChartByDay" width="400" height="200"></canvas>
            </div>

            <!-- Biểu đồ lượt mượn theo tháng -->
            <div class="container form-container">
                <h4 class="mb-4 text-center">Thống kê lượt mượn sách theo tháng</h4>
                <canvas id="borrowChartByMonth" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Dữ liệu thống kê theo ngày
        const statsByDay = @json($statsByDay);
        const labelsByDay = statsByDay.map(item => item.date); // Danh sách ngày
        const dataByDay = statsByDay.map(item => item.borrow_count); // Lượt mượn

        // Biểu đồ thống kê theo ngày
        const ctxByDay = document.getElementById('borrowChartByDay').getContext('2d');
        new Chart(ctxByDay, {
            type: 'line',
            data: {
                labels: labelsByDay,
                datasets: [{
                    label: 'Số lượt mượn sách (theo ngày)',
                    data: dataByDay,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Ngày'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Lượt mượn'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Dữ liệu thống kê theo tháng
        const statsByMonth = @json($statsByMonth);
        const labelsByMonth = statsByMonth.map(item => `Tháng ${item.month}`); // Danh sách tháng
        const dataByMonth = statsByMonth.map(item => item.borrow_count); // Lượt mượn

        // Biểu đồ thống kê theo tháng
        const ctxByMonth = document.getElementById('borrowChartByMonth').getContext('2d');
        new Chart(ctxByMonth, {
            type: 'bar',
            data: {
                labels: labelsByMonth,
                datasets: [{
                    label: 'Số lượt mượn sách (theo tháng)',
                    data: dataByMonth,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Lượt mượn'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection