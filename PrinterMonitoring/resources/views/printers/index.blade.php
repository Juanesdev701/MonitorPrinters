<!-- resources/views/printers/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Printers</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('printers.create') }}" class="btn btn-primary mb-4">Add New Printer</a>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>IP Address</th>
                    <th>Toner Level</th>
                    <th>Link</th>                    
                    <th>Delete</th>                    
                </tr>
            </thead>
            <tbody>
                @foreach($printers as $printer)
                    <tr>
                        <td>{{ $printer->id }}</td>
                        <td>{{ $printer->name }}</td>
                        <td>{{ $printer->ip_address }}</td>
                        <td>{{ $printer->toner_level }}%</td>
                        <td><a href="http://{{ $printer->ip_address }}" target="_blank">View Status</a></td>
                        <td>
                            <form action="{{ route('printers.destroy', $printer->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this printer?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('printers.updateTonerLevels') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-primary">Update Toner Levels</button>
        </form>
        @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    </div>
    <script>
    document.querySelector('form').onsubmit = function() {
        document.querySelector('button[type="submit"]').disabled = true;
    };
</script>
    
@endsection
