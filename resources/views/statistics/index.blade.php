@extends('layouts.admin')
@section('title', 'Thống kê doanh thu & Top sản phẩm bán chạy')
@section('content')
<div class="content-wrapper">
    @include('partials.content-header',['name'=>'Thống kê','key'=>'Doanh thu & Top bán chạy'])
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" class="form-inline mb-3">
                        <label for="filter_type" class="mr-2">Lọc theo:</label>
                        <select name="filter_type" id="filter_type" class="form-control mr-2">
                            <option value="week" {{ request('filter_type') == 'week' ? 'selected' : '' }}>Tuần</option>
                            <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Tháng</option>
                            <option value="quarter" {{ request('filter_type') == 'quarter' ? 'selected' : '' }}>Quý</option>
                            <option value="year" {{ request('filter_type') == 'year' ? 'selected' : '' }}>Năm</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <strong>Doanh thu: {{ number_format($revenue, 0, ',', '.') }}đ</strong>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <canvas id="revenueChart" style="width:100vw; max-width:100vw; height:550px;"></canvas>
                </div>
                <div class="col-md-12">
                    <h4>Top sản phẩm bán chạy</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->total_sold }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Doanh thu'],
                datasets: [{
                    label: 'Doanh thu',
                    data: [{{ $revenue }}],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
