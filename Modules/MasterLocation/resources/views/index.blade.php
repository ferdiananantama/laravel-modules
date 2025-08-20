@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="app-content container mt-4">
        <h1 class="mb-4">Dashboard - Master Location</h1>

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
        <form method="GET" action="{{ route('masterlocation.index') }}" class="mb-3">
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
                    <th class="text-center">Name Location</th>
                    <th class="text-center" style="white-space: nowrap; width: 1%;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                @forelse ($locations as $index => $location)
                    <tr>
                        <td class="text-center">{{ $locations->firstItem() + $index }}</td>
                        <td class="text-center">{{ $location->name }}</td>
                        <td class="text-end" style="white-space: nowrap;">
                            <!-- Tombol Edit dan Delete, buka modal dengan ID unik -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $location->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $location->id }}">Delete</button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $location->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('masterlocation.update', $location->id) }}">
                                @csrf @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Location</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $location->name }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning btn-update">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true"></span>
                                            <span class="btn-text">Update</span>
                                        </button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{ $location->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('masterlocation.destroy', $location->id) }}">
                                @csrf @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Delete Location</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete <strong>{{ $location->name }}</strong>?</p>
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
                        <td colspan="3" class="text-center text-muted">No Data locations found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
        <div>
            {{ $locations->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- ✅ Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('masterlocation.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name Location</label>
                            <input type="text" name="name" class="form-control" required>
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
