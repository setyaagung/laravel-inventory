@extends('layouts.backend.main')

@section('title','Profil Perusahaan')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Perusahaan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Perbarui!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{ route('company.update',$company->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Nama Perusahaan</label>
                    <input type="text" class="form-control" name="name" value="{{ $company->name}}">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="address" class="form-control" rows="4">{{ $company->address}}</textarea>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="number" class="form-control" name="phone" value="{{ $company->phone}}">
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="number" class="form-control" name="mobile" value="{{ $company->mobile}}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $company->email}}">
                </div>
                <div class="float-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection