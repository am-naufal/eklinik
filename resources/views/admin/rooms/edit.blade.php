@extends('layouts.app')

@section('title', 'Edit Ruang Rawat Inap')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Ruang Rawat Inap</h1>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.rooms.update', $room) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="room_number">Nomor Ruangan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('room_number') is-invalid @enderror"
                                    id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}"
                                    required>
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Kamar <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $room->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="room_type">Tipe Ruangan <span class="text-danger">*</span></label>
                                <select class="form-control @error('room_type') is-invalid @enderror" id="room_type"
                                    name="room_type" required>
                                    <option value="">Pilih Tipe Ruangan</option>
                                    <option value="VIP"
                                        {{ old('room_type', $room->room_type) == 'VIP' ? 'selected' : '' }}>VIP
                                    </option>
                                    <option value="Kelas 1"
                                        {{ old('room_type', $room->room_type) == 'Kelas 1' ? 'selected' : '' }}>Kelas 1
                                    </option>
                                    <option value="Kelas 2"
                                        {{ old('room_type', $room->room_type) == 'Kelas 2' ? 'selected' : '' }}>Kelas 2
                                    </option>
                                    <option value="Kelas 3"
                                        {{ old('room_type', $room->room_type) == 'Kelas 3' ? 'selected' : '' }}>Kelas 3
                                    </option>
                                </select>
                                @error('room_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="floor">Lantai <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('floor') is-invalid @enderror"
                                    id="floor" name="floor" value="{{ old('floor', $room->floor) }}" min="1"
                                    required>
                                @error('floor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="capacity">Kapasitas <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                    id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}"
                                    min="1" required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price_per_day">Harga per Hari <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control @error('price_per_day') is-invalid @enderror"
                                        id="price_per_day" name="price_per_day"
                                        value="{{ old('price_per_day', $room->price_per_day) }}" min="0" required>
                                </div>
                                @error('price_per_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="available"
                                        {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Tersedia
                                    </option>
                                    <option value="maintenance"
                                        {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance
                                    </option>
                                    <option value="occupied"
                                        {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Terisi</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
