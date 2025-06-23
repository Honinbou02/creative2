@extends('LogManager::layouts.master')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Log Dashboard</h1>
        <div class="row">
            @foreach($logStats as $folderName => $stats)
                <div class="col-lg-6">
                    <div class="card mb-4">
                    <div class="card-header">
                        <h3>{{ formatLogName($folderName) }} Logs</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Folder Statistics</h5>
                                        <ul class="list-unstyled">
                                            <li>Total Log Files: {{ $stats['total_files'] }}</li>
                                            <li>Total Log Size: {{ number_format($stats['total_size'] / 1024, 2) }} KB</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Log Entries Analysis</h5>
                                        <div id="chart-{{ $folderName }}" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.2/echarts.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach($logStats as $folderName => $stats)
                // Prepare data for ECharts
                const dailyLogData{{ $folderName }} = @json($stats['logs_by_date']);
                const monthlyLogData{{ $folderName }} = @json($stats['log_entries_by_month']);

                // Initialize the echarts instance
                const chart{{ $folderName }} = echarts.init(document.getElementById('chart-{{ $folderName }}'));

                // Specify the configuration items and data for the chart
                const option{{ $folderName }} = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend: {
                        data: ['Daily Logs', 'Monthly Logs']
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: Object.keys(dailyLogData{{ $folderName }}),
                            axisLabel: {
                                rotate: 45,
                                interval: Math.floor(Object.keys(dailyLogData{{ $folderName }}).length / 10)
                            }
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            name: 'Log Entries'
                        }
                    ],
                    series: [
                        {
                            name: 'Daily Logs',
                            type: 'bar',
                            data: Object.values(dailyLogData{{ $folderName }}),
                            color: '#3498db'
                        },
                        {
                            name: 'Monthly Logs',
                            type: 'line',
                            data: Object.values(monthlyLogData{{ $folderName }}),
                            color: '#e74c3c'
                        }
                    ]
                };

                // Use the configuration item and data specified to show the chart
                chart{{ $folderName }}.setOption(option{{ $folderName }});
                @endforeach
            });
        </script>
    @endsection