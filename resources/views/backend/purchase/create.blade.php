@extends('layouts.backend.main')

@section('title','Purchase Order')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Purchase Order</h1>
    </div>

    <div class="card shadow mb-4">
        @if ($message = Session::get('gagal'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Perbarui!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        <div class="card-body">
            <form action="{{ route('purchase.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nomor Dokumen</label>
                    <input type="text" class="form-control" name="document_number" value="{{ $doc }}" readonly>
                </div>
                @if (isset($supplier))
                    <div class="form-group">
                        <label>Supplier</label>
                        <select class="form-control select2bs4" name="supplier_id" style="width: 100%">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $sp)
                                <option value="{{ $sp->id }}" {{ ($supplier == $sp->id) ? 'selected' : ''}}>{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="form-group">
                        <label>Supplier</label>
                        <select class="form-control select2bs4" name="supplier_id" style="width: 100%">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if (isset($products))
                <div class="table-responsive mt-5">
                    <table class="table table-striped" id="dataTable" style="width: 100%">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nama</td>
                                <td>Harga Beli</td>
                                <td>Qty</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $p=>$product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp. {{ number_format($product->buy,2,',','.') }}</td>
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                        <input type="number" value="0" class="form-control" name="qty[]">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    <a href="{{ route('purchase.index')}}" class="btn btn-danger btn-block">Batal</a>
                </div>
            @endif
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("select[name='supplier_id']").change(function(e){
                var supplier_id = $(this).val();
                var url = "{{ url('purchase/product')}}"+'/'+supplier_id;

                window.location.href = url;
            });
        });
    </script>
@endpush