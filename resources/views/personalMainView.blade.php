@extends('template')
@section('content')
    <style></style>
    <div class="container">
        <div class="row mt-4">
            <div class="col d-flex justify-content-center">
                <h2 class="text-center text-black" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);">Trabajadores</h2>
            </div>
        </div>
        <div class="table-responsive">
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
                                data-target="#editarModal" @if ($t->activo != 0)
                                disabled
                            @endif><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#verModal"><i
                                    class="bi bi-eye"></i></button>
                            <button type="button" class="btn btn-danger deletealert" data-toggle="modal"
                                data-target="#eliminarModal" @if ($t->activo != 0)
                                    disabled
                                @endif><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
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
                                <div class="row pb-4">
                                    <div class="col"><label for="name">Name:</label></div>
                                    <div class="col"><input type="text" id="name"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="surname">Surname:</label></div>
                                    <div class="col"><input type="text" id="surname"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="sex">Sex:</label></div>
                                    <div class="col">
                                        <select name="sex" id="sex" class="custom-select" style="width: 95%">
                                            <option value="" selected disabled>Choose an option</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="phone">Phone:</label></div>
                                    <div class="col"><input type="text" id="phone"></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="dni_type">Identification Number:</label></div>
                                    <div class="col">
                                        <select name="dni_type" id="dni_type" class="custom-select" style="width: 95%">
                                            <option value="" selected disabled>Choose an option</option>
                                            <option value="DNI">DNI</option>
                                            <option value="NIE">NIE</option>
                                            <option value="PASSPORT">PASSPORT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="dni">Identification:</label></div>
                                    <div class="col"><input type="text" id="dni"></div>
                                </div>

                                <div class="row pb-4">
                                    <div class="col"><label for="country">Country:</label></div>
                                    <div class="col"><select name="country" id="country" class="custom-select"
                                            style="width: 95%">
                                            <option value="" selected disabled>Choose an option</option>

                                        </select></div>
                                </div>
                                <div class="row pb-4">
                                    <div class="col"><label for="email">Email:</label></div>
                                    <div class="col"><input type="text" id="email"></div>
                                </div>
                                <div class="row">
                                    <div class="col"><label for="rol">Rol:</label></div>
                                    <div class="col">
                                        <div class="col">
                                            <select name="rol" id="rol" class="custom-select"
                                                style="width: 95%">
                                                <option value="" selected disabled>Choose an option</option>
                                                <option value="ENCARGADO">ENCARGADO</option>
                                                <option value="TRABAJADOR">TRABAJADOR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <p id="errorMessage" style="display: none; color:red;text-align: center;">Algunos de los campos anteriores no son validos, por favor reviselos.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
