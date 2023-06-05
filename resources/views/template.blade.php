<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <!-- Sweet Alert 2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css" rel="stylesheet">

    <title>Dashboard</title>
    <style>
        .dash-icon-hover:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        .dash-icon-hover>div>svg {
            width: 100px;
            height: 100px;
        }

        /* .dash-icon-hover{
        border: solid 1px black;
        border-radius: 25px;
      } */
        .gap-menu {
            gap: 10rem !important;
        }

        /* #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preloader .spinner-border {
            margin-top: -2em;
        } */
        .fila-roja {
            background-color: lightcoral !important
        }

        .is-invalid {
            border-color: red;
            color: red
        }

        select>option {
            color: black
        }
    </style>
    @bukStyles(true)
</head>

<body>


    <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary bg-dark " data-bs-theme="dark">
            <div class="container-fluid ">
                <a class="navbar-brand" href="dashboard">INCOES</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Perfil
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a class="dropdown-item" href="logout">Desconectar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>

    <script src=""></script>
    <script>
        function mostrarPreloader() {
            Swal.fire({
                title: 'Please Wait !',
                html: 'Data is loading . . .', // add html attribute if you want or remove
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
        }

        function basicAlert(titulo,comentario='',tipo='succes') {
            Swal.fire(
                titulo,
                comentario,
                tipo
            )
        }

        function ocultarPreloader() {
            Swal.close();
        }

        function vaciarYRellenarTabla() {
            // Realiza la petición Ajax
            mostrarPreloader();
            var formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                url: '/resfrescar/tabla/trabajadores', // Cambia esto por la URL de tu servidor que devolverá los datos
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    // Vaciar la tabla
                    $('table').DataTable().clear();
                    data.forEach(element => {
                        $('table').DataTable().row.add([
                            element.dni,
                            element.name,
                            element.surname,
                            element.phone,
                            element.rol,
                            '<button type="button" class="btn btn-primary editmodal" data-toggle="modal" data-target="#editarModal"><i class="bi bi-pencil-square"></i></button> <button type="button" class="btn btn-info" data-toggle="modal" data-target="#verModal"><i class="bi bi-eye"></i></button> <button type="button" class="btn btn-danger deletealert" data-toggle="modal" data-target="#eliminarModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"> <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" /></svg></button>',
                        ]).draw().node();
                    });
                    console.log(data);
                    ocultarPreloader();
                },
                error: function() {
                    ocultarPreloader();
                    console.error('Error al obtener los datos.');
                }
            });
        }
        $(document).ready(function() {
            var token = $('meta[name="csrf-token"]').attr('content');
            $('.a-click').click(function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                window.location.href = id;
            });
            var table = new DataTable('table', {
                language: {

                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad",
                        "collection": "Colección",
                        "colvisRestore": "Restaurar visibilidad",
                        "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                        "copySuccess": {
                            "1": "Copiada 1 fila al portapapeles",
                            "_": "Copiadas %ds fila al portapapeles"
                        },
                        "copyTitle": "Copiar al portapapeles",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Mostrar todas las filas",
                            "_": "Mostrar %d filas"
                        },
                        "pdf": "PDF",
                        "print": "Imprimir",
                        "renameState": "Cambiar nombre",
                        "updateState": "Actualizar",
                        "createState": "Crear Estado",
                        "removeAllStates": "Remover Estados",
                        "removeState": "Remover",
                        "savedStates": "Estados Guardados",
                        "stateRestore": "Estado %d"
                    },
                    "autoFill": {
                        "cancel": "Cancelar",
                        "fill": "Rellene todas las celdas con <i>%d<\/i>",
                        "fillHorizontal": "Rellenar celdas horizontalmente",
                        "fillVertical": "Rellenar celdas verticalmentemente"
                    },
                    "decimal": ",",
                    "searchBuilder": {
                        "add": "Añadir condición",
                        "button": {
                            "0": "Constructor de búsqueda",
                            "_": "Constructor de búsqueda (%d)"
                        },
                        "clearAll": "Borrar todo",
                        "condition": "Condición",
                        "conditions": {
                            "date": {
                                "after": "Despues",
                                "before": "Antes",
                                "between": "Entre",
                                "empty": "Vacío",
                                "equals": "Igual a",
                                "notBetween": "No entre",
                                "notEmpty": "No Vacio",
                                "not": "Diferente de"
                            },
                            "number": {
                                "between": "Entre",
                                "empty": "Vacio",
                                "equals": "Igual a",
                                "gt": "Mayor a",
                                "gte": "Mayor o igual a",
                                "lt": "Menor que",
                                "lte": "Menor o igual que",
                                "notBetween": "No entre",
                                "notEmpty": "No vacío",
                                "not": "Diferente de"
                            },
                            "string": {
                                "contains": "Contiene",
                                "empty": "Vacío",
                                "endsWith": "Termina en",
                                "equals": "Igual a",
                                "notEmpty": "No Vacio",
                                "startsWith": "Empieza con",
                                "not": "Diferente de",
                                "notContains": "No Contiene",
                                "notStartsWith": "No empieza con",
                                "notEndsWith": "No termina con"
                            },
                            "array": {
                                "not": "Diferente de",
                                "equals": "Igual",
                                "empty": "Vacío",
                                "contains": "Contiene",
                                "notEmpty": "No Vacío",
                                "without": "Sin"
                            }
                        },
                        "data": "Data",
                        "deleteTitle": "Eliminar regla de filtrado",
                        "leftTitle": "Criterios anulados",
                        "logicAnd": "Y",
                        "logicOr": "O",
                        "rightTitle": "Criterios de sangría",
                        "title": {
                            "0": "Constructor de búsqueda",
                            "_": "Constructor de búsqueda (%d)"
                        },
                        "value": "Valor"
                    },
                    "searchPanes": {
                        "clearMessage": "Borrar todo",
                        "collapse": {
                            "0": "Paneles de búsqueda",
                            "_": "Paneles de búsqueda (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Sin paneles de búsqueda",
                        "loadMessage": "Cargando paneles de búsqueda",
                        "title": "Filtros Activos - %d",
                        "showMessage": "Mostrar Todo",
                        "collapseMessage": "Colapsar Todo"
                    },
                    "select": {
                        "cells": {
                            "1": "1 celda seleccionada",
                            "_": "%d celdas seleccionadas"
                        },
                        "columns": {
                            "1": "1 columna seleccionada",
                            "_": "%d columnas seleccionadas"
                        },
                        "rows": {
                            "1": "1 fila seleccionada",
                            "_": "%d filas seleccionadas"
                        }
                    },
                    "thousands": ".",
                    "datetime": {
                        "previous": "Anterior",
                        "next": "Proximo",
                        "hours": "Horas",
                        "minutes": "Minutos",
                        "seconds": "Segundos",
                        "unknown": "-",
                        "amPm": [
                            "AM",
                            "PM"
                        ],
                        "months": {
                            "0": "Enero",
                            "1": "Febrero",
                            "10": "Noviembre",
                            "11": "Diciembre",
                            "2": "Marzo",
                            "3": "Abril",
                            "4": "Mayo",
                            "5": "Junio",
                            "6": "Julio",
                            "7": "Agosto",
                            "8": "Septiembre",
                            "9": "Octubre"
                        },
                        "weekdays": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mie",
                            "Jue",
                            "Vie",
                            "Sab"
                        ]
                    },
                    "editor": {
                        "close": "Cerrar",
                        "create": {
                            "button": "Nuevo",
                            "title": "Crear Nuevo Registro",
                            "submit": "Crear"
                        },
                        "edit": {
                            "button": "Editar",
                            "title": "Editar Registro",
                            "submit": "Actualizar"
                        },
                        "remove": {
                            "button": "Eliminar",
                            "title": "Eliminar Registro",
                            "submit": "Eliminar",
                            "confirm": {
                                "_": "¿Está seguro que desea eliminar %d filas?",
                                "1": "¿Está seguro que desea eliminar 1 fila?"
                            }
                        },
                        "error": {
                            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                        },
                        "multi": {
                            "title": "Múltiples Valores",
                            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                            "restore": "Deshacer Cambios",
                            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                        }
                    },
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "stateRestore": {
                        "creationModal": {
                            "button": "Crear",
                            "name": "Nombre:",
                            "order": "Clasificación",
                            "paging": "Paginación",
                            "search": "Busqueda",
                            "select": "Seleccionar",
                            "columns": {
                                "search": "Búsqueda de Columna",
                                "visible": "Visibilidad de Columna"
                            },
                            "title": "Crear Nuevo Estado",
                            "toggleLabel": "Incluir:"
                        },
                        "emptyError": "El nombre no puede estar vacio",
                        "removeConfirm": "¿Seguro que quiere eliminar este %s?",
                        "removeError": "Error al eliminar el registro",
                        "removeJoiner": "y",
                        "removeSubmit": "Eliminar",
                        "renameButton": "Cambiar Nombre",
                        "renameLabel": "Nuevo nombre para %s",
                        "duplicateError": "Ya existe un Estado con este nombre.",
                        "emptyStates": "No hay Estados guardados",
                        "removeTitle": "Remover Estado",
                        "renameTitle": "Cambiar Nombre Estado"
                    }

                },
                paging: false
            });

            $('.editmodal').click(function(e) {
                e.preventDefault();
                mostrarPreloader();
                let dni = $(this).parent().siblings().eq(0).text();

                // Obtener los datos del formulario
                var formData = {
                    dni: dni
                };

                // Agregar el token CSRF a los datos del formulario
                formData._token = token;
                //console.log(token);
                //console.log(dni);
                $.ajax({
                    type: "post",
                    url: "/datosTrabajador",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        //console.log(response);

                        $('#name').val(response.name);
                        $('#surname').val(response.surname);
                        $('#sex').val(response.sex);
                        $('#phone').val(response.phone);
                        $('#dni_type').val(response.identification);
                        $('#dni').val(response.dni);
                        $('#dni_old').val(response.dni);
                        $('#country').val(response.country);
                        $('#email').val(response.email);
                        $('#rol').val(response.rol);
                        ocultarPreloader();

                        $('#editarModal').modal('toggle');
                    },
                    error: function(xhr, status, error) {
                        // Manejar el error

                        console.log(xhr.responseText);
                        ocultarPreloader();
                    }
                });

            });

            $('#closeEditModal').click(function(e) {
                $('#editarModal').modal('toggle');
            });
            $(".deletealert").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        mostrarPreloader();
                        let dni = $(this).parent().siblings().eq(0).text();
                        let fila = $(this).parent().parent();
                        // Obtener los datos del formulario
                        var formData = {
                            dni: dni
                        };

                        // Agregar el token CSRF a los datos del formulario
                        formData._token = token;

                        $.ajax({
                            type: "post",
                            url: "/desactivar/Trabajador",
                            data: formData,
                            dataType: "json",
                            success: function(response) {
                                //console.log(response);
                                if (response) {
                                    //console.log(fila);
                                    fila.remove();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: "Something didn´t work, contact support",
                                        icon: 'error',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    })
                                }

                            },
                            error: function(xhr, status, error) {
                                // Manejar el error
                                ocultarPreloader();
                                console.log(xhr.responseText);
                                Swal.fire({
                                    title: 'Error',
                                    text: "Something didn´t work, contact support",
                                    icon: 'error',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                })
                            }
                        });

                    }
                })
            });

            const selectElement = document.getElementById('countries-select');

            // Realiza una petición para obtener el archivo JSON de los países
            fetch(window.location.origin + '/countries.json')
                .then(response => response.json())
                .then(data => {
                    // Recorre los datos del archivo JSON
                    for (let index = 0; index < data.countries.length; index++) {
                        const element = data.countries[index];

                        $('#country').append('<option value="' + element.es_name + '">' + element.es_name +
                            '</option>');
                    }
                });
            $('#submit').click(function(e) {
                e.preventDefault();
                
                var fields = $('#editForm').find('input[type="text"], select');
                var isFormValid = true;
                fields.each(function() {
                    var field = $(this);

                    if (field.val() == '' || field.val() == null) {
                        console.log(field);
                        isFormValid = false;
                        field.addClass(
                            'is-invalid'); // Agregar clase 'is-invalid' para resaltar campos vacíos
                        $('#errorMessage').show();
                    } else {
                        field.removeClass(
                            'is-invalid'); // Eliminar clase 'is-invalid' si el campo no está vacío

                    }
                    
                });
                if (isFormValid) {
                        $('#errorMessage').hide();
                        mostrarPreloader();
                        let formData = $('#editForm').serialize();
                        $.ajax({
                            type: "post",
                            url: "/editar/formulario/trabajadores",
                            data: formData,
                            dataType: "json",
                            success: function(response) {
                                ocultarPreloader();
                                $('#editarModal').modal('toggle');
                                console.log(response);
                                if (response) {
                                    var titulo="Updated!";
                                    var comentario="Worker update correctly.";
                                    var tipo="success";
                                } else {
                                    var titulo="Error";
                                    var comentario="Something didn´t work, contact support";
                                    var tipo="error";
                                }
                                basicAlert(titulo,comentario,tipo);
                            },
                            error: function(xhr, status, error) {
                                // Manejar el error

                                console.log(xhr.responseText);
                                ocultarPreloader();
                            }
                        });
                    }
            });

        });
    </script>
    @bukScripts(true)
</body>

</html>
