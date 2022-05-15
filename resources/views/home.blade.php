@extends('layouts.app')

@section('style')

@endsection

@section('javascript')

<script>
    @if (\Session::has('success'))  
        Swal.fire({
            position: 'top-end',
            type: 'success',
            title: "{{\Session::get('success')}}",
            showConfirmButton: false,
            timer: 4000,
            customClass: "sweetAlert"
        })
    @endif

    @if (\Session::has('warning'))  
        Swal.fire({
            position: 'top-end',
            type: 'warning',
            title: "{{\Session::get('warning')}}",
            showConfirmButton: false,
            timer: 4000,
            customClass: "sweetAlert"
        })
    @endif

</script>

@endsection

@section('title')
Inicio

@endsection

@section('content')
<div class="row ">
    <div class="col-lg-12">
        <div id="asd"></div>
        <div class="card-header h3 col-md-12">Inicio</div>
            
        </div>
    </div>
@endsection
