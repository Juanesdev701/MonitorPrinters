<!-- resources/views/printers/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Add New Printer</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('printers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Printer Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="ip_address">IP Address</label>
                <input type="text" class="form-control" id="ip_address" name="ip_address" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Printer</button>
        </form>
    </div>
@endsection
