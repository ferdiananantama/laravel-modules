@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="app-content container mt-4">
        <h1 class="mb-4">Dashboard - Monitoring</h1>

        <!-- ✅ Button Add -->
        <div class="d-flex justify-content-start">
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                + Add Location
            </button>
        </div>

        <!-- ✅ Table -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    const success = document.getElementById("alert-success");
                    const error = document.getElementById("alert-error");

                    if (success) {
                        const alert = new bootstrap.Alert(success);
                        alert.close();
                    }
                    if (error) {
                        const alert = new bootstrap.Alert(error);
                        alert.close();
                    }
                }, 1000);
            });
        </script>
        <form class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Search location...">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="white-space: nowrap; width: 1%;">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Shift</th>
                    <th class="text-center">Work Hours</th>
                    <th class="text-center">Jumlah User</th>
                    <th class="text-center">Output</th>
                    <th class="text-center" style="white-space: nowrap; width: 1%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monitorings as $index => $m)
                    <tr>
                        <td class="text-center">{{ $monitorings->firstItem() + $index }}</td>
                        <td class="text-center">{{ $m->tanggal }}</td>
                        <td class="text-center">{{ $m->location->name ?? '-' }}</td>
                        <td class="text-center">{{ $m->shift }}</td>
                        <td class="text-center">{{ $m->work_hours }}</td>
                        <td class="text-center">{{ $m->jumlah_user }}</td>
                        <td class="text-center">{{ $m->output }}</td>
                        <td class="text-end" style="white-space: nowrap;">
                            <!-- Tombol Edit dan Delete -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $m->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $m->id }}">Delete</button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $m->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('monitoring.update', $m->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Monitoring</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- semua input form sesuai field Monitoring -->
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control"
                                                value="{{ $m->tanggal }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Location</label>
                                            <select name="location_id" class="form-select" required>
                                                @foreach ($locations as $loc)
                                                    <option value="{{ $loc->id }}"
                                                        {{ $m->location_id == $loc->id ? 'selected' : '' }}>
                                                        {{ $loc->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Shift</label>
                                            <input type="text" name="shift" class="form-control"
                                                value="{{ $m->shift }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Work Hours</label>
                                            <input type="number" step="0.01" name="work_hours" class="form-control"
                                                value="{{ $m->work_hours }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Start Hours</label>
                                            <input type="time" name="start_hours" class="form-control"
                                                value="{{ $m->start_hours }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Breaktime 1</label>
                                            <input type="time" name="breaktime1" class="form-control"
                                                value="{{ $m->breaktime1 }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Breaktime 2</label>
                                            <input type="time" name="breaktime2" class="form-control"
                                                value="{{ $m->breaktime2 }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Break Duration (jam)</label>
                                            <input type="number" step="0.01" name="break_duration"
                                                class="form-control" value="{{ $m->break_duration }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">End Hours</label>
                                            <input type="time" name="end_hours" class="form-control"
                                                value="{{ $m->end_hours }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah User</label>
                                            <input type="number" name="jumlah_user" class="form-control"
                                                value="{{ $m->jumlah_user }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Output</label>
                                            <input type="number" name="output" class="form-control"
                                                value="{{ $m->output }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{ $m->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('monitoring.destroy', $m->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Delete Monitoring</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus data monitoring tanggal
                                            <strong>{{ $m->tanggal }}</strong> di lokasi
                                            <strong>{{ $m->location->name ?? '-' }}</strong>?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger">Yes, Delete</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No Monitoring data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div>
            {{ $monitorings->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- ✅ Modal Add -->
    <!-- ✅ Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('monitoring.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Monitoring</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <select name="location_id" class="form-select" required>
                                <option value="">-- Select Location --</option>
                                @foreach ($locations as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shift</label>
                            <input type="text" name="shift" class="form-control" placeholder="Shift 1 / Shift 2"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Work Hours (jam)</label>
                            <input type="number" step="0.01" name="work_hours" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start Hours</label>
                            <input type="time" name="start_hours" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Breaktime 1</label>
                            <input type="time" name="breaktime1" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Breaktime 2</label>
                            <input type="time" name="breaktime2" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Break Duration (jam)</label>
                            <input type="number" step="0.01" name="break_duration" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Hours</label>
                            <input type="time" name="end_hours" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah User</label>
                            <input type="number" name="jumlah_user" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Output</label>
                            <input type="number" name="output" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // handle semua form submit di modal
            document.querySelectorAll('.modal form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const spinner = submitBtn.querySelector('.spinner-border');
                        const text = submitBtn.querySelector('.btn-text');
                        submitBtn.disabled = true;
                        if (spinner) spinner.classList.remove('d-none');
                        if (text) text.textContent = 'Processing...';
                    }
                });
            });
        });
    </script>
@endpush
