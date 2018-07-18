@extends('layouts.app')
@section('title', $User->name)
@section('content')
    <style>
        .fa-edit{
            font-size: 1.4rem;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }
        .fa-times{
            font-size: 1.4rem;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }
        .fa-chevron-circle-down{
            font-size: 1.4rem;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }
        .fa-times .fa-edit:hover{
            color: #7a7a7a;
        }
        .portada{
            width: 2000px;
            height: 400px;
        }
        .info{
          position: relative;
           top:-180px;
           z-index: 2;
        }
        .datos{
            background: white;
        }
        .nombre{
            position: relative;
            top: -120px;
            left: 600px;
        }
        .cont-portada{
          margin-top: -25px;
          padding: 0;
        }
    </style>

    <!--PORTADA-->

    <div class="container-fluid cont-portada" style="z-index: 1;">
        <div class="row">
            <div class="col-md-12">
                <img class="img-fluid portada" src="{{ asset('images/Material.jpg') }}" alt="responsive image">
            </div>
        </div>
    </div>

    <!--FIN PORTADA-->

    <!--CONTENIDO-->

    <div class="container info">
        <div class="row">

            <!-- FOTO DE PERFIL -->

            <div class="col-lg-3 pb-5">
                <div class="card mx-auto shadow" style="width: 15rem;">

                    <img class="card-img-top img-responsive"
                    src=@if(!$User->profile_picture == null)
                            "/images/profile_pictures/{{ $User->profile_picture }}" 
                        @else
                             "{{ asset('images/default.png') }}"
                        @endif>
                    @if($User->id == Auth::User()->id)    
                    <div class="card-body text-center">
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#ModalPerfil">{{ __('Cambiar imagen') }}</button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- FIN FOTO DE PERFIL -->

            <!--INFORMACION DE USUARIO -->

            <div class="col-lg-9 col-xs-12 col-sm-12 shadow datos">

                <div class="col-md-12 my-3">
                    <h4 class="text-center">{{ __('Perfil') }}</h4>
                    <hr>
                </div>
                <div class="col-md-12 text-right">
                    @if($User->id == Auth::User()->id)
                        @if($edit == false)
                            <a href="{{ route('ProfileEdit',['id'=>$User->id]) }}">
                                <i class="fas fa-edit" data-toggle="tooltip" data-placement="right" title="Editar Información"></i>
                            </a>
                        @else
                            <a href="{{ route('ProfileUser',['id'=>$User->id]) }}">
                                <i class="fas fa-times" data-toggle="tooltip" data-placement="right" title="Cancelar"></i>
                            </a>
                        @endif
                    @endif
                </div>
                <div class="col-lg-8 col-md-12 col-xs-12 offset-lg-2 pb-3">
                    @if(session('status'))
                        <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="col-lg-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ( $errors->all() as $error )
                                    {{ $error }}
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('ProfileUpdate',['id'=>$User->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Nombre de usuario') }}</label>
                                <input type="text" @if($edit==false) readonly @endif class="form-control" name="name" 
                                    pattern="[A-Z a-z]{3,14}" title="Mínimo 3 caracteres, máximo 14, sin números ni caracteres especiales" value="{{ $User->name }}" required>
                            </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email"  @if($edit==false) readonly @endif class="form-control" name="email" 
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="{{ $User->email }}" required>
                        </div>
                         @if($edit==true)
                            <div class="text-center py-2">
                                <button type="submit" class="btn btn-outline-success">{{ __('Actualizar información') }}</button>
                            </div>
                        @endif
                    
                </div>
            </div>

            <!--FIN INFORMACION DE USUARIO -->
           
            <!--INFORMACION PERSONAL -->

            <div class="col-lg-9 shadow py-3 my-3 offset-lg-3 datos">
                <div class="col-md-12 my-3">
                    <h4 class="text-center">{{ __('Información personal') }}</h4>
                    <hr>
                </div>
                <div class="col-lg-8 col-md-12 col-xs-12 offset-lg-2 pb-3" id="info_personal">
                    <div class="form-group">
                        <label for="names">{{ __('Nombres') }}</label>
                        <input type="text" class="form-control" @if($edit==false) readonly @endif name="names" required value="{{ $User->names }}" required>
                    </div>
                    <div class="form-group">
                        <label for="paternal_surname">{{ __('Apellido Paterno') }}</label>
                        <input type="text" name="paternal_surname" class="form-control" @if($edit==false) readonly @endif value="{{ $User->paternal_surname }}" required>
                    </div>
                    <div class="form-group">
                        <label for="maternal_surname">{{ __('Apellido Materno') }}</label>
                        <input type="text" name="maternal_surname" class="form-control" @if($edit==false) readonly @endif value="{{ $User->maternal_surname }}" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">{{ __('Genero') }}</label>
                        <select name="gender" class="form-control" @if($edit==false) readonly disabled @endif>
                            <option @if($User->gender=="masculino") selected="selected" @endif value="masculino">{{ __('Masculino') }}</option>
                            <option @if($User->gender=="femenino") selected="selected" @endif value="femenino">{{ __('Femenino') }}</option>
                        </select>
                    </div>
                    @if($User->id == Auth::User()->id)
                        <div class="form-group">
                            <label for="birthdate">{{ __('Fecha de nacimiento') }}</label>
                            <input type="date" class="form-control" name="birthdate" @if($edit==false) readonly @endif value="{{ $User->birthdate }}" required> 
                        </div>
                        <div class="form-group">
                            <label for="curp">{{ __('CURP') }}</label>
                            <input type="text" class="form-control" name="curp" @if($edit==false) readonly @endif value="{{ $User->curp }}" required>
                        </div>
                        <div class="form-group">
                            <label for="state">{{ __('Estado') }}</label>
                            <input type="text" name="state" class="form-control" @if($edit==false) readonly @endif value="{{ $User->state }}">
                        </div>
                        <div class="form-group">
                            <label for="municipality">{{ __('Municipio') }}</label>
                            <input type="text" name="municipality" class="form-control" @if($edit==false) readonly @endif value="{{ $User->municipality }}">
                        </div>
                        <div class="form-group">
                            <label for="colony">{{ __('Colonia') }}</label>
                            <input type="text" name="colony" class="form-control" @if($edit==false) readonly @endif value="{{ $User->colony }}">
                        </div>
                        <div class="form-group">
                            <label for="street">{{ __('Calle') }}</label>
                            <input type="text" name="street" class="form-control" @if($edit==false) readonly @endif value="{{ $User->street }}">
                        </div>
                        <div class="form-group">
                            <label for="external_number">{{ __('Número interior') }}</label>
                            <input type="number" name="external_number" class="form-control" @if($edit==false) readonly @endif value="{{ $User->external_number }}">
                        </div>
                        <div class="form-group">
                            <label for="internal_number">{{ __('Número interior') }}</label>
                            <input type="number" name="internal_number" class="form-control" @if($edit==false) readonly @endif value="{{ $User->internal_number }}">
                        </div>
                        <div class="form-group">
                            <label for="zipcode">{{ __('Código postal') }}</label>
                            <input type="number" name="zipcode" class="form-control" @if($edit==false) readonly @endif value="{{ $User->zipcode }}">
                        </div>
                        <div class="form-group">
                            <label for="cellphone">{{ __('Teléfono celular') }}</label>
                            <input type="text" name="cellphone" class="form-control" @if($edit==false) readonly @endif value="{{ $User->cellphone }}">
                        </div>
                        <div class="form-group">
                            <label for="local_phone">{{ __('Teléfono local') }}</label>
                            <input type="text" name="local_phone" class="form-control" @if($edit==false) readonly @endif value="{{ $User->local_phone }}">
                        </div>
                        <div class="form-group">
                            <label for="professional_license">{{ __('Cédula profesional') }}</label>
                            <input type="text" name="professional_license" class="form-control" @if($edit==false) readonly @endif value="{{ $User->professional_license }}">
                        </div>
                        <div class="form-group">
                            <label for="rfc">{{ __('RFC') }}</label>
                            <input type="text" name="rfc" class="form-control" @if($edit==false) readonly @endif value="{{ $User->rfc }}">
                        </div>
                        <div class="form-group">
                            <label for="contact_name">{{ __('En caso de emergencia llamar a :') }}</label>
                            <input type="text" name="contact_name" class="form-control" @if($edit==false) readonly @endif value="{{ $User->contact_name }}">
                        </div>
                        <div class="form-group">
                            <label for="contact_number">{{ __('Al número :') }}</label>
                            <input type="text" name="contact_number" class="form-control" @if($edit==false) readonly @endif value="{{ $User->contact_number }}">
                        </div>
                        <div class="form-group">
                            <label for="allergy">{{ __('Alergías') }}</label>
                            <select name="allergy" class="form-control" @if($edit==false) readonly disabled @endif>
                                <option @if($User->allergy==true) selected="selected" @endif value="1">{{ __('Sí') }}</option>
                                <option @if($User->allergy==false) selected="selected" @endif value="0">{{ __('No') }}</option>
                            </select>
                        </div>
                        @if($User->allergy==true || $edit==true)
                            <div class="form-group">
                                <label for="allergy_description">{{ __('Descripción de alergías') }}</label>
                                <input type="text" name="allergy_description" class="form-control" @if($edit==false) readonly @endif value="{{ $User->allergy_description }}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="controlled_medication">{{ __('Medicamento controlado') }}</label>
                            <select name="controlled_medication" class="form-control" @if($edit==false) readonly disabled @endif>
                                <option @if($User->controlled_medication==true) selected="selected" @endif value="1">{{ __('Sí') }}</option>
                                <option @if($User->controlled_medication==false) selected="selected" @endif value="0">{{ __('No') }}</option>
                            </select>
                        </div>
                        @if($User->controlled_medication==true || $edit==true)
                            <div class="form-group">
                                <label for="medication_description">{{ __('Descripción de medicamento') }}</label>
                                <input type="text" name="medication_description" class="form-control" @if($edit==false) readonly @endif value="{{ $User->medication_description }}">
                            </div>
                        @endif
                        
                            @if($edit==true)
                            <div class="text-center py-2">
                                <button type="submit" class="btn btn-outline-success">{{ __('Actualizar información') }}</button>
                            </div>
                            @endif
                    @endif
                    </form>
                </div>
            </div>

            <!--FIN INFORMACION PERSONAL -->

            <!--INFORMACION DE ADMINISTRADOR -->

            @if($User->id == Auth::User()->id)
                <div class="col-lg-9 shadow py-3 my-3 offset-lg-3 datos">
                    <div class="col-md-12 my-3">
                        <h4 class="text-center">{{ __('Administrador') }}</h4>
                        <hr>
                    </div>
                    <div class="col-lg-8 col-md-12 col-xs-12 offset-lg-2 pb-3">
                        <!--Formulario si el usuario es administrador--!>
                        <form action="" method="post">    
                            <div class="form-group">
                                <label for="nip">{{ __('NIP') }}</label>
                                <input type="number" name="nip" class="form-control" @if($edit==false) readonly @endif value="{{ $User->nip }}">
                            </div>
                            <div class="form-group">
                                <label for="card_id">{{ __('Tarjeta de identificación') }}</label>
                                <input type="text" name="card_id" class="form-control" @if($edit==false) readonly @endif value="{{ $User->card_id }}">
                            </div>
                            <div class="form-group">
                                <label for="scholarship_id">{{ 'Beca' }}</label>
                                
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- FIN INFORMACION DE ADMINISTRADOR -->
        </div>
    </div>

    <!--FIN CONTENIDO-->

    <!--MODAL CAMBIO DE PROFILE PICTURE-->

    <div class="modal fade" id="ModalPerfil" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>{{ __('Foto de perfil') }}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ProfileUpdate',['id'=>$User->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="profile_picture">{{ __('Selecciona una imagen') }}</label>
                            <input type="file" class="form-control-file" name="profile_picture" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-outline-success">{{ __('Actualizar Imagen') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--FIN MODAL CAMBIO DE PROFILE PICTURE-->

@endsection