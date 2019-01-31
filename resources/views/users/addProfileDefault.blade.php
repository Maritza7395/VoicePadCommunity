@extends('master')
@section('notVue')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('FOTOS POR DEFECTO') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                     
                    <form method="POST" action="{{ route('addProfileDefault') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row shadow p-3 mb-5 bg-white rounded">
                            <div style="text-align: center;width: 100%;"><h4>Foto de Perfil Femenino</h4></div>
                            <div class="row" style="width: 100%;">
                                <div class="col-md-4">
                                    <img  width="150px" src="{{ asset('storage/profilePicture/defaultF')}}">
                                </div>
                                <div class="col-md-6 align-self-center">   
                                    <div class="row">
                                        <p><label for="avatarF">
                                            <input style="border: 1px solid red; border-radius: 3px;" type="file" name="avatarF" accept="image/*" {{ $errors->has('avatarF') ? ' is-invalid' : '' }}>
                                        </label></p>
                                    </div> 
                                    <div class="row">
                                        {!! $errors->first('avatarF','<span class="error alert alert-danger">:message</span>') !!}
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        
                        <div class="row shadow p-3 mb-5 bg-white rounded">
                            <div style="text-align: center;width: 100%;"><h4>Foto de Perfil Masculino</h4></div>
                            <div class="row" style="width: 100%;">
                                <div class="col-md-4">
                                    <img  width="150px" src="{{ asset('storage/profilePicture/defaultM')}}">
                                </div>
                                <div class="col-md-6 align-self-center">   
                                    <div class="row">
                                        <p><label for="avatarM">
                                            <input style="border: 1px solid red; border-radius: 3px;" type="file" name="avatarM" accept="image/*" {{ $errors->has('avatarM') ? ' is-invalid' : '' }}>                                        
                                        </label></p>
                                    </div> 
                                    <div class="row">
                                        {!! $errors->first('avatarM','<span class="error alert alert-danger">:message</span>') !!}
                                    </div>                            
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row shadow p-3 mb-5 bg-white rounded">
                            <div style="text-align: center; width: 100%;"><h4>Portada del Libro</h4></div>
                            <div class="row" style="width: 100%;">
                                <div class="col-md-4 files">
                                <img width="150px" src="{{ asset('storage/coverText/default')}}">
                            </div>
                            <div class="col-md-6 align-self-center">   
                                <div class="row">
                                    <p><label for="cover">
                                        <input  type="file" style="border: 1px solid red; border-radius: 3px;" name="cover" accept="image/*" {{ $errors->has('cover') ? ' is-invalid' : '' }}>                                        
                                    </label></p>
                                </div> 
                                <div class="row">
                                    {!! $errors->first('cover','<span class="error alert alert-danger">:message</span>') !!}
                                </div>                            
                                
                            </div>
                            </div>
                            
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar') }}
                        </button>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Estilos')
<style>
    .btn.btn-primary {
      background: #9b111e none repeat scroll 0 0;
      border-color: #f0ad4e;
      color: #ffffff;
      font-size: 14px;
      width: 100%;
      height: 40px;
      padding: 0;
    }
</style>
@endsection