@extends('layouts.pemilik')

@section('title', 'Detail Laporan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan</h1>
            <div>
                <a href="{{ route('pemilik.reports.edit', $report->id) }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-2">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit Laporan
                </a>
                <a href="{{ route('pemilik.reports.index') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Report Information Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 30%">Judul</th>
                                <td>{{ $report->title }}</td>
                            </tr>
                            <tr>
                                <th>Tipe</th>
                                <td>
                                    @if ($report->type == 'keuangan')
                                        <span class="badge badge-success">Keuangan</span>
                                    @elseif($report->type == 'kunjungan')
                                        <span class="badge badge-info">Kunjungan</span>
                                    @elseif($report->type == 'medis')
                                        <span class="badge badge-warning">Medis</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $report->type }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td>{{ $report->start_date->format('d M Y') }} - {{ $report->end_date->format('d M Y') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 30%">Dibuat Oleh</th>
                                <td>{{ $report->creator->name }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diperbarui Pada</th>
                                <td>{{ $report->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if ($report->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="font-weight-bold">Deskripsi:</h6>
                            <p>{{ $report->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Report Data Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Laporan</h6>
            </div>
            <div class="card-body">
                @if ($report->type == 'keuangan')
                    <!-- Keuangan Report -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h4 class="font-weight-bold text-primary">Total Pendapatan</h4>
                                    <h2 class="font-weight-bold">Rp
                                        {{ number_format($report->data['total_income'] ?? 0, 0, ',', '.') }}</h2>
                                    <p>Dari {{ $report->data['appointment_count'] ?? 0 }} kunjungan yang selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="chart-bar">
                                <canvas id="incomeChart"></canvas>
                            </div>
                        </div>
                    </div>
                @elseif($report->type == 'kunjungan')
                    <!-- Kunjungan Report -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="small font-weight-bold">Total Kunjungan</h4>
                                            <h2 class="font-weight-bold text-primary">{{ $report->data['total'] ?? 0 }}
                                            </h2>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <h4 class="small font-weight-bold">Selesai</h4>
                                            <h3 class="font-weight-bold text-success">{{ $report->data['completed'] ?? 0 }}
                                            </h3>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="small font-weight-bold">Pending</h4>
                                            <h3 class="font-weight-bold text-warning">{{ $report->data['pending'] ?? 0 }}
                                            </h3>
                                        </div>
                                        <div class="col-4">
                                            <h4 class="small font-weight-bold">Batal</h4>
                                            <h3 class="font-weight-bold text-danger">{{ $report->data['cancelled'] ?? 0 }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="chart-bar">
                                <canvas id="visitChart"></canvas>
                            </div>
                            <div class="mt-4">
                                <h6 class="font-weight-bold">Kunjungan per Dokter</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Dokter</th>
                                                <th class="text-center">Jumlah Kunjungan</th>
                                                <th class="text-center">Persentase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($report->data['by_doctor']))
                                                @foreach ($report->data['by_doctor'] as $doctor)
                                                    <tr>
                                                        <td>{{ $doctor['name'] }}</td>
                                                        <td class="text-center">{{ $doctor['count'] }}</td>
                                                        <td class="text-center">
                                                            {{ round(($doctor['count'] / ($report->data['total'] ?: 1)) * 100, 1) }}%
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data dokter</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($report->type == 'medis')
                    <!-- Medis Report -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h4 class="font-weight-bold text-primary">Total Rekam Medis</h4>
                                    <h2 class="font-weight-bold">{{ $report->data['total_records'] ?? 0 }}</h2>
                                    <hr>
                                    <h6 class="font-weight-bold mt-3">Rekam Medis per Dokter</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Dokter</th>
                                                    <th class="text-center">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($report->data['by_doctor']))
                                                    @foreach ($report->data['by_doctor'] as $doctor)
                                                        <tr>
                                                            <td>{{ $doctor['name'] }}</td>
                                                            <td class="text-center">{{ $doctor['count'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="chart-pie mb-4">
                                <canvas id="treatmentChart"></canvas>
                            </div>
                            <div class="text-center">
                                <h6 class="font-weight-bold">Jenis Treatment</h6>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        Tipe laporan tidak dikenali atau data laporan tidak tersedia.
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            @if ($report->type == 'keuangan' && isset($report->data['income_by_date']))
                // Financial Report Chart
                var incomeData = @json($report->data['income_by_date'] ?? []);
                var labels = Object.keys(incomeData);
                var values = Object.values(incomeData);

                var ctx = document.getElementById("incomeChart");
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Pendapatan (Rp)",
                            backgroundColor: "#4e73df",
                            hoverBackgroundColor: "#2e59d9",
                            borderColor: "#4e73df",
                            data: values,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                maxBarThickness: 25,
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    callback: function(value) {
                                        return 'Rp ' + value.toString().replace(
                                            /\B(?=(\d{3})+(?!\d))/g, ".");
                                    }
                                },
                            }],
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    return 'Rp ' + tooltipItem.yLabel.toString().replace(
                                        /\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                });
            @endif

            @if ($report->type == 'kunjungan' && isset($report->data['by_date']))
                // Visit Report Chart
                var visitData = @json($report->data['by_date'] ?? []);
                var labels = Object.keys(visitData);
                var values = Object.values(visitData);

                var ctx = document.getElementById("visitChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Jumlah Kunjungan",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: values,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    beginAtZero: true
                                },
                            }],
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Kunjungan per Hari'
                        }
                    }
                });
            @endif

            @if ($report->type == 'medis' && isset($report->data['common_treatments']))
                // Medical Report Chart
                var treatmentData = @json($report->data['common_treatments'] ?? []);
                var labels = Object.keys(treatmentData);
                var values = Object.values(treatmentData);

                var ctx = document.getElementById("treatmentChart");
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                                '#858796', '#5a5c69'
                            ],
                            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a',
                                '#be2617', '#6a6c7a', '#3a3b45'
                            ],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        cutoutPercentage: 0,
                    }
                });
            @endif
        });
    </script>
@endsection
