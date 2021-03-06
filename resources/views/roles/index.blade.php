@extends('layouts.app')
@section('title','Control de Roles')
@section('content')
   <div class="container">
       <div class="row">
           <div class="col-lg-12 py-3">
               <h3>{{ __('Control de Roles') }}</h3>
           </div>
           <div class="col-lg-6 col-sm-12 text-md-left text-center py-3">
               <a href="{{ route('RoleCreate') }}" class="btn btn-outline-success"><i class="fas fa-plus-circle"></i>{{ __(' Nuevo Rol') }}</a>
           </div>
           <div class="col-lg-6 col-sm-12 text-md-right text-center py-3">
               <form action="" method="get">
                    <div class="input-group my-1">
                        <input type="text" class="form-control" name="busqueda" placeholder="Buscar..." value="{{ $busqueda }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary">{{ __('Buscar') }}</button>
                        </div>
                    </div>
                </form>
           </div>
           <div class="col-lg-6 offset-lg-3 col-sm-12 py-2">
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
           </div>
           <div class="col-lg-12">
               <div class="table-responsive">
                   <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Rol') }}</th>
                                <th scope="col">{{ __('Permisos') }}</th>
                                <th scope="col">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="align-middle">{{ $role->name }}</td>
                                    <td class="align-middle">
                                        @foreach($roles_has_permissions as $rhp)
                                            @if($rhp->role_id == $role->id)
                                                <span class="badge badge-pill badge-primary">{{ $rhp->permission->name }}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="align-middle">
                                        @if($role->name != "Administrador" && $role->name != "Coordinador" && $role->name != "Alumno" && $role->name != "Docente")
                                            <a href="{{ route('RoleEdit',['id'=>$role->id]) }}" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="left" 
                                                title="Modificar"><i class="fas fa-edit"></i></a>
                                            <span data-toggle="tooltip" data-placement="right" title="Eliminar">
                                                <button class="btn btn-outline-danger px-3 open-modal" data-toggle="modal" data-target="#EliminarRol"
                                                    data-id="{{ $role->id }}"><i class="fas fa-times"></i>
                                                </button>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
   <!--MODAL ELIMINAR ROL-->
    @include('roles.ModalEliminar')
   <!--FIN MODAL ELIMINAR ROL-->

   
@endsection

<!--FUNCION OBTENER ID-->
    @section('scripts')
        <script src="{{ asset('js/modalDatos.js') }}"></script>
    @endsection
<!--FIN FUNCION OBTENER ID-->