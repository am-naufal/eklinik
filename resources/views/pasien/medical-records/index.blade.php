@extends('layouts.app')

@section('title', 'Rekam Medis - E-Klinik')

@section('page-title', 'Rekam Medis Saya')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Rekam Medis</h6>
                </div>
                <div class="card-body">
                    @if ($medicalRecords->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-file-medical fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada rekam medis</p>
                        </div>
                    @else
                        <div class="timeline-container">
                            @foreach ($medicalRecords as $record)
                                <div class="timeline-item">
                                    <div class="timeline-date">{{ $record->created_at->format('d F Y') }}</div>
                                    <div class="timeline-content">
                                        <h6>{{ $record->appointment->type ?? 'Pemeriksaan Umum' }}</h6>
                                        <p>dr. {{ $record->doctor->name }}</p>
                                        <p><strong>Diagnosa:</strong> {{ $record->diagnosis }}</p>
                                        <p><strong>Tindakan:</strong> {{ $record->treatment }}</p>
                                        <a href="{{ route('pasien.medical-records.show', $record) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $medicalRecords->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .timeline-container {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e3e6f0;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-date {
            font-weight: bold;
            margin-bottom: 10px;
            color: #4e73df;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #4e73df;
        }

        .timeline-container:before {
            content: '';
            position: absolute;
            left: -23px;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: #e3e6f0;
        }
    </style>
@endsection
