@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <a href="{{ route('pengumuman.create') }}" class="btn btn-primary mb-3">Create Pengumuman</a>
    @foreach($pengumuman as $p)
        <div class="alert alert-info">
            <h4><strong>{{ $p->judul }}</strong></h4>
            <p>{{ $p->isi }}</p>
            <small>{{ $p->created_at ? $p->created_at->format('d-m-Y H:i') : 'Tanggal tidak tersedia' }}</small>
            <div>
                <a href="{{ route('pengumuman.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('pengumuman.destroy', $p->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
