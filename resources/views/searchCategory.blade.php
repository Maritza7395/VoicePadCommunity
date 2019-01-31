@extends('master')
@section('contenido')
<div class="container" >
    <div id="motivations" class="justify-content-center">
            <div class="col-md-10 justify-content-center">
                {{-- <h1 class="" style="text-align: center">Administracion de Motivos-Texto</h1> --}}
            </div>
            <div  id="app">
                   <search id="{{ $data }}"></search>
            </div>
            <div class="col-sm-5">
                
            </div>
    </div>
</div>
@endsection