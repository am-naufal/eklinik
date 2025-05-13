<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #{{ $invoice->invoice_number }} - eKlinik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .invoice-title {
            font-size: 20px;
            margin: 15px 0 5px;
        }

        .invoice-number {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .invoice-date {
            font-size: 14px;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-box {
            width: 48%;
        }

        .info-box h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .info-item {
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background-color: #f5f5f5;
            text-align: left;
        }

        .total-section {
            text-align: right;
            margin-bottom: 30px;
        }

        .total-row {
            font-size: 16px;
            font-weight: bold;
        }

        .notes {
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            font-size: 12px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            color: white;
        }

        .status-pending {
            background-color: #f6c23e;
        }

        .status-paid {
            background-color: #1cc88a;
        }

        .status-cancelled {
            background-color: #e74a3b;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            margin-top: 70px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }

            .invoice-container {
                border: none;
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="logo">eKlinik</div>
            <div>Jl. Kesehatan No. 123, Jakarta Selatan</div>
            <div>Telp: (021) 123-4567 | Email: info@eklinik.com</div>
            <div class="invoice-title">NOTA PENANGANAN</div>
            <div class="invoice-number">No. {{ $invoice->invoice_number }}</div>
            <div class="invoice-date">Tanggal: {{ $invoice->created_at->format('d M Y H:i') }}</div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3>Data Pasien</h3>
                <div class="info-item">
                    <span class="info-label">Nama</span>: {{ $invoice->patient->user->name }}
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon</span>:
                    {{ $invoice->patient->phone_number ?? $invoice->patient->user->phone_number }}
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>: {{ $invoice->patient->user->email }}
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat</span>:
                    {{ $invoice->patient->address ?? $invoice->patient->user->address }}
                </div>
            </div>
            <div class="info-box">
                <h3>Status Pembayaran</h3>
                <div class="info-item">
                    <span class="info-label">Status</span>:
                    <span class="status-badge status-{{ $invoice->payment_status }}">
                        @if ($invoice->payment_status == 'pending')
                            MENUNGGU PEMBAYARAN
                        @elseif($invoice->payment_status == 'paid')
                            LUNAS
                        @elseif($invoice->payment_status == 'cancelled')
                            DIBATALKAN
                        @endif
                    </span>
                </div>
                @if ($invoice->payment_status == 'paid')
                    <div class="info-item">
                        <span class="info-label">Tanggal Bayar</span>: {{ $invoice->paid_at->format('d M Y H:i') }}
                    </div>
                @endif
                <div class="info-item">
                    <span class="info-label">Dokter</span>: {{ $invoice->doctor->user->name }}
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th width="20%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @if ($invoice->medicalRecord)
                    <tr>
                        <td>
                            <strong>Diagnosis:</strong> {{ $invoice->medicalRecord->diagnosis }}
                            <br>
                            <strong>Penanganan:</strong>
                            {{ $invoice->medicalRecord->treatments->first() ? $invoice->medicalRecord->treatments->first()->name : '-' }}
                        </td>
                        <td>Rp
                            {{ number_format($invoice->total_amount - $invoice->items->sum('subtotal'), 0, ',', '.') }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>Biaya Penanganan</td>
                        <td>Rp
                            {{ number_format($invoice->total_amount - $invoice->items->sum('subtotal'), 0, ',', '.') }}
                        </td>
                    </tr>
                @endif

                @if (count($invoice->items) > 0)
                    <tr>
                        <td colspan="2" class="font-weight-bold">Daftar Obat</td>
                    </tr>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>
                                {{ $item->medicine->name }} ({{ $item->quantity }} x Rp
                                {{ number_format($item->price, 0, ',', '.') }})
                                @if ($item->notes)
                                    <br><small>Catatan: {{ $item->notes }}</small>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">Total: Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</div>
        </div>

        @if ($invoice->notes)
            <div class="notes">
                <h3>Catatan:</h3>
                <p>{{ $invoice->notes }}</p>
            </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">{{ $invoice->creator->name }}</div>
                <div>Petugas</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">{{ $invoice->patient->user->name }}</div>
                <div>Pasien</div>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah berobat di eKlinik. Semoga lekas sembuh.</p>
            <p>Dokumen ini dicetak pada {{ \Carbon\Carbon::now()->format('d M Y H:i') }}.</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background-color: #4e73df; color: white; border: none; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak Nota
        </button>
        <button onclick="window.close()"
            style="padding: 10px 20px; background-color: #858796; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>
</body>

</html>
