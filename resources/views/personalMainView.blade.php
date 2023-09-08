@extends('template')
@section('content')
    <?php
    // Obtén el agente de usuario del navegador
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) { ?>

    <?php } else {?>
    <div class="container" id="ezo">
        <?php }?>

        <div class="row mt-4">
            <div class="col d-flex justify-content-center">
                <h2 class="text-center text-black" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);">Trabajadores</h2>
            </div>
        </div>
        {{-- <div class="row mt-4 dash-icon-hover justify-content-center">
            <div class="col-3 col-sm-2 col-md-2 d-flex justify-content-center small" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Volver al menú" id="dashboard">
                {{ svg('ri-logout-box-line') }}
            </div>
            <div class="col-3 col-sm-2 col-md-2 d-flex justify-content-center adduser small" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Añadir un nuevo trabajador">
                {{ svg('ri-user-add-line') }}
            </div>
            <div class="col-3 col-sm-2 col-md-2 d-flex justify-content-center pdf small" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Descargar un excel del listado" id="excelTrabajadores">
                {{ svg('ri-file-excel-2-line') }}
            </div>
            <div class="col-3 col-sm-2 col-md-2 d-flex justify-content-center pdf small" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Enviar el listado a mi correo electrónico" id="recibirEmailTrabajador">
                {{ svg('ri-mail-download-line') }}
            </div>
            <div class="col-3 col-sm-2 col-md-2 d-flex justify-content-center pdf small" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Enviar el listado a otra persona" id="enviarEmailTrabajador">
                {{ svg('ri-send-plane-fill') }}
            </div>
        </div> --}}
        <div class="row mt-4 justify-content-center">
            <!-- Slider main container -->
            <div class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"><div class="icono-trabajadores">{{ svg('ri-logout-box-line') }}</div></div>
                    <div class="swiper-slide"><div class="icono-trabajadores"> {{ svg('ri-user-add-line') }}</div></div>
                    <div class="swiper-slide"><div class="icono-trabajadores">{{ svg('ri-file-excel-2-line') }}</div></div>
                    ...
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                {{-- <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div> --}}

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-hover table-striped" id="tabla">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        @if ($rol == 'root')
                            <th>Empresa</th>
                        @endif

                        <th>Ajustes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($test as $t)
                        @if ($t->activo != 0)
                            <tr class="fila-roja">
                            @else
                            <tr>
                        @endif

                        <td>{{ $t->dni }}</td>
                        <td>{{ $t->name }}</td>
                        <td>{{ $t->surname }}</td>
                        <td>{{ $t->phone }}</td>
                        <td>{{ $t->rol }}</td>
                        @if ($rol == 'root')
                            <th>{{ $t->company }}</th>
                        @endif
                        <td>
                            <button type="button" class="btn btn-primary editmodal" data-toggle="modal"
                                data-target="#editarModal" @if ($t->activo != 0) disabled @endif><i
                                    class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-info calendarmodal" data-toggle="modal"
                                data-target="#calendarModal"><i class="bi bi-calendar-plus"></i></button>
                            <button type="button" class="btn btn-danger deletealert" data-toggle="modal"
                                data-target="#eliminarModal" @if ($t->activo != 0) disabled @endif><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path
                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg></button>

                        </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT WORKER</h5>
                        <button type="button" class="btn btn-secondary" id="closeEditModal">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form action="#" method="post" id="editForm">
                                @csrf
                                <input type="hidden" name="dni_old" id="dni_old">
                                <div class="row pb-4">
                                    <div class="col"><label for="name">Name:</label></div>
                                    <div class="col"><input type="text" id="name" name="name"
                                            class="form-control"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="surname">Surname:</label></div>
                                    <div class="col"><input type="text" id="surname" name="surname"
                                            class="form-control"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="sex">Sex:</label></div>
                                    <div class="col">
                                        <select name="sex" id="sex" class="custom-select" style="width: 95%">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="phone">Phone:</label></div>
                                    <div class="col"><input type="text" id="phone" name="phone"
                                            class="form-control"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="dni_type">Identification Number:</label></div>
                                    <div class="col">
                                        <select name="dni_type" id="dni_type" class="custom-select" style="width: 95%">
                                            <option value="DNI">DNI</option>
                                            <option value="NIE">NIE</option>
                                            <option value="PASSPORT">PASSPORT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="dni">Identification:</label></div>
                                    <div class="col"><input type="text" id="dni" name="dni"
                                            class="form-control"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="country">Country:</label></div>
                                    <div class="col">
                                        <select name="country" id="country" class="custom-select" style="width: 95%">

                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="email">Email:</label></div>
                                    <div class="col"><input type="text" id="email" name="email"
                                            class="form-control"></div>
                                </div>
                                <div class="row">
                                    <div class="col"><label for="rol">Rol:</label></div>
                                    <div class="col">
                                        <select name="rol" id="rol" class="custom-select" style="width: 95%">
                                            <option value="ENCARGADO">ENCARGADO</option>
                                            <option value="TRABAJADOR">TRABAJADOR</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <p id="errorMessage" style="display: none; color:red;text-align: center;">Algunos de los
                                campos anteriores no son validos, por favor reviselos.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal  fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Holidays</h5>
                        <button type="button" class="btn btn-secondary" id="closeCalendarModal">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4 botonesVacaciones">
                            <div class="col d-flex justify-content-center">
                                <button id="btnAgregarEvento" class="btn btn-success" style="background-color: green;"
                                    data-bs-toggle="modal" data-bs-target="#añadirFecha">
                                    <i class="bi bi-plus-lg"></i>
                                    Añadir Vacaciones
                                </button>
                            </div>
                            <div class="col d-flex justify-content-center">
                                <button id="btnEliminarEvento" class="btn btn-error"
                                    style="background-color: red;color:white">
                                    <i class="bi bi-dash-lg"></i>
                                    Eliminar Vacaciones
                                </button>
                            </div>
                        </div>

                        <div id="calendar"></div>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="modal fade" id="añadirFecha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Añadir Vacaciones</h5>
                        <button type="button" class="btn btn-secondary cerrarVacaciones" data-bs-dismiss="modal"
                            aria-label="Close" id="cerrarVacacionesAñadir"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="añadirVacaciones">
                            @csrf
                            <div class="form-group">
                                <label for="fechaInicio">Fecha de Inicio:</label>
                                <input type="text" id="fechaInicio" name="fechaInicio" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="fechaFin">Fecha de Fin:</label>
                                <input type="text" id="fechaFin" name="fechaFin" class="form-control"
                                    style="display: none" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitAñadirVacaciones">Guardar
                            cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="eliminarFecha" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Vacaciones</h5>
                        <button type="button" class="btn btn-secondary cerrarVacaciones" data-bs-dismiss="modal"
                            aria-label="Close"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="eliminarVacaciones">
                            @csrf
                            <div class="form-check">
                                <div class="container-fluid">
                                    <div class="row justify-content-start eliminardias">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitEliminarVacaciones">Guardar
                            cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Añadir Trabajador</h5>
                        <button type="button" class="btn btn-secondary cerrarUser" data-bs-dismiss="modal"
                            aria-label="Close"><i class="bi bi-x-lg"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="container mt-5">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <form action="" method="post" id="adduserForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="apellidos" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="apellidos" name="surname"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="emailAdd" name="email"
                                                data-bs-toggle="tooltip" title="Formato no válido"
                                                data-bs-placement="right" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contrasenia" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="contrasenia" name="password"
                                                data-bs-toggle="tooltip" title="La contraseña es muy débil"
                                                data-bs-placement="right" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="sex" class="form-label">Sexo</label>
                                            <select class="form-select" id="sexAdd" name="sex" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="identificacion" class="form-label">Identificación</label>
                                            <select class="form-select" id="identificacion" name="identification"
                                                required>
                                                <option value="DNI">DNI</option>
                                                <option value="NIE">NIE</option>
                                                <option value="PASSPORT">PASSPORT</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="dni" class="form-label">Numero de identificacion</label>
                                            <input type="text" class="form-control" id="dniAdd" name="dni"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pais" class="form-label">País</label>
                                            <select class="form-select" id="pais" name="country" required>

                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="telefono" name="phone"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rol" class="form-label">Rol</label>
                                            <select class="form-select" id="rolAdd" name="rol" required>
                                                <option value="ENCARGADO">ENCARGADO</option>
                                                <option value="TRABAJADOR">TRABAJADOR</option>
                                            </select>
                                        </div>
                                        {{-- <button type="submit" class="btn btn-primary">Enviar</button> --}}
                                    </form>
                                    <br>
                                    <p id="errorMessage" style="display: none; color:red;text-align: center;">Algunos de
                                        los
                                        campos anteriores no son validos, por favor reviselos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitadduser">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <?php if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) { ?>

        <?php } else {?>
    </div>
    <?php }?>
@endsection
