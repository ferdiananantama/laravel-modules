@extends('layouts.app')

@section('title', 'Timesheet')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Timesheet - {{ $date }}</h1>

        <form method="POST" action="{{ route('timesheet.store') }}">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $row)
                        @php
                            $now = \Carbon\Carbon::now();
                            $isEditable = $now->between($row['editable_start'], $row['editable_end'], false);
                        @endphp
                        <tr>
                            <td>{{ $row['time'] }}</td>
                            <td>
                                <input type="text" name="notes[{{ $row['time'] }}]" class="form-control"
                                    value="{{ $row['note'] }}" @if (!$isEditable) disabled @endif>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
