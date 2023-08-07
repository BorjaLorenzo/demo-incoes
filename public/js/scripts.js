function mostrarPreloader(titulo="'Please Wait !'",texto="Data is loading . . .") {
    Swal.fire({
        title: titulo,
        html: texto, // add html attribute if you want or remove
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading()
        },
        didClose: () => {
            Swal.hideLoading()
        }
    });
}

function basicAlert(titulo = "Hola mundo", comentario = 'Que tal?', tipo = 'succes') {
    Swal.fire({
        title: titulo,
        html: comentario,
        icon: tipo, // add html attribute if you want or remove
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.hideLoading()
        }
    });
}

function ocultarPreloader() {
    Swal.close();
}

function vaciarYRellenarTabla(titulo, texto, icono) {
    // Realiza la petición Ajax

    var formData = {
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        url: '/resfrescar/tabla/trabajadores', // Cambia esto por la URL de tu servidor que devolverá los datos
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            // Vaciar la tabla
            //console.log(data);
            $('#tabla').DataTable().clear();
            data.forEach(element => {
                var disableButtons = element.activo === 1;
                var row = [
                    element.dni,
                    element.name,
                    element.surname,
                    element.phone,
                    element.rol,
                    '<button type="button" class="btn btn-primary editmodal" data-toggle="modal" data-target="#editarModal" ' + (disableButtons ? 'disabled' : '') + '><i class="bi bi-pencil-square"></i></button> <button type="button" class="btn btn-info calendarmodal" data-toggle="modal" data-target="#calendarModal"><i class="bi bi-calendar-plus"></i></button> <button type="button" class="btn btn-danger deletealert" data-toggle="modal" data-target="#eliminarModal" ' + (disableButtons ? 'disabled' : '') + '><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"> <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" /></svg></button>',];

                var rowNode = $('#tabla').DataTable().row.add(row).draw().node();

                // Verificar la condición (element.activo igual a 0)
                if (element.activo === 1) {
                    $(rowNode).addClass('fila-roja');
                }
                if (disableButtons) {
                    $(rowNode).find('.editmodal, .deletealert').prop('disabled', true);
                }
            });
            //$('#tabla').DataTable().draw();
            //console.log(data);
            ocultarPreloader();
            //basicAlert("Updated!", "Worker update correctly.", "success");
            basicAlert(titulo, texto, icono);
        },
        error: function () {
            //ocultarPreloader();
            console.error('Error al obtener los datos.');
        }
    });
}


// function agregarEvento(title,start,end,color) {
//     var evento = {
//         title: title,
//         start: start,
//         end: end,
//         color: color
//     };
//     calendar.addEvent(evento);
// }

function diaSiguiente(fecha) {
    // Crear una fecha con la fecha inicial
    var fechaInicial = new Date(fecha);

    // Sumar un día a la fecha inicial
    fechaInicial.setDate(fechaInicial.getDate() + 1);

    // Obtener los componentes de la fecha actualizada
    var año = fechaInicial.getFullYear();
    var mes = ('0' + (fechaInicial.getMonth() + 1)).slice(-2);
    var dia = ('0' + fechaInicial.getDate()).slice(-2);

    // Crear la cadena de fecha en formato yy-mm-dd
    var fechaActualizadaString = año + '-' + mes + '-' + dia;

    // Imprimir la fecha actualizada
    return fechaActualizadaString;
}


$(document).ready(function () {
    //variables globales
    var token = $('meta[name="csrf-token"]').attr('content');
    var calendarButtons = false;
    var fechaActual = new Date();
    var fechaActualString = $.datepicker.formatDate('yy-mm-dd', fechaActual);
    var fechaActualStringFin;
    var dni;




    if (window.location.pathname == "/personal") {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            selectable: true,

        });

        calendar.setOption('locale', 'es');

        // calendar.on('dateClick', function (info) {
        //     //console.log('clicked on ' + info.dateStr);
        // });

    }

    $('#tabla').on('click', '.calendarmodal', function (e) {
        e.preventDefault();
        calendar.removeAllEvents();
        calendarButtons = $(this).parent().parent().hasClass("fila-roja");
        dni = $(this).parent().siblings().eq(0).text();
        if (calendarButtons) {
            $('.botonesVacaciones').hide();
        } else {
            $('.botonesVacaciones').show();
        }
        mostrarPreloader();
        var formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            dni: dni
        };
        $.ajax({
            type: "post",
            url: "/editar/calendario/vacaciones",
            data: formData,
            dataType: "json",
            success: function (response) {
                //console.log(response);
                response.forEach(element => {
                    calendar.addEvent({
                        title: 'Día de vacaciones',
                        start: element.fecha_inicio,
                        end: element.fecha_fin,
                        color: 'red'
                    });
                });
                $("#calendarModal").modal("toggle");
                $('#calendarModal').on('shown.bs.modal', function () {

                    calendar.render();
                });
                ocultarPreloader();
            }
        });

    });

    $('.a-click').click(function (e) {
        e.preventDefault();
        
        let id = $(this).attr('id');
        mostrarPreloader(id.toUpperCase(),"Un momento porfavor.");
        window.location.href = id;
    });
    var table = new DataTable('#tabla', {
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
        paging: false,
    });
    $('#tabla').on('click', '.editmodal', function (e) {
        // Lógica para el botón editar
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
            success: function (response) {
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
            error: function (xhr, status, error) {
                // Manejar el error

                //console.log(xhr.responseText);
                ocultarPreloader();
            }
        });
    });
    $('#closeEditModal').click(function (e) {
        $('#editarModal').modal('toggle');
    });
    $('#closeCalendarModal').click(function (e) {
        $('#calendarModal').modal('toggle');
        calendar.removeAllEvents();
    });
    $('#tabla').on('click', '.deletealert', function (e) {
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
                //let fila = $(this).parent().parent();
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
                    success: function (response) {
                        //console.log(response);
                        if (response) {
                            //console.log(fila);
                            // fila.remove();
                            vaciarYRellenarTabla("Deleted!", "Worker deleted correctly.", "success");
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
                    error: function (xhr, status, error) {
                        // Manejar el error
                        ocultarPreloader();
                        //console.log(xhr.responseText);
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

                $('#country , #pais').append('<option value="' + element.es_name + '">' + element.es_name +
                    '</option>');

            }
        });
    $('#submit').click(function (e) {
        e.preventDefault();

        var fields = $('#editForm').find('input[type="text"], select');
        var isFormValid = true;
        fields.each(function () {
            var field = $(this);

            if (field.val() == '' || field.val() == null) {
                //console.log(field);
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
                success: function (response) {

                    $('#editarModal').modal('toggle');
                    //console.log(response);
                    if (response) {
                        vaciarYRellenarTabla("Updated!", "Worker update correctly.", "success");
                    } else {
                        var titulo = "Error";
                        var comentario = "Something didn´t work, contact support";
                        var tipo = "error";
                        basicAlert(titulo, comentario, tipo);
                    }


                },
                error: function (xhr, status, error) {
                    // Manejar el error

                    //console.log(xhr.responseText);
                    ocultarPreloader();
                }
            });
        }
    });


    $('#fechaInicio').on('change', function () {
        $("#fechaFin").datepicker("destroy");
        $('#fechaFin').val("");
        $('#fechaFin').show();
        fechaActualStringFin = diaSiguiente($('#fechaInicio').val());

        $("#fechaFin").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: fechaActualStringFin
        });
    });

    $('#submitAñadirVacaciones').on('click', function () {
        var inicio = $('#fechaInicio').val();
        var fin = $('#fechaFin').val()

        var formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            dni: dni,
            inicio: inicio,
            fin: fin
        };

        mostrarPreloader();
        if (inicio != '' && fin != '') {

            $.ajax({
                type: "post",
                url: "/añadir/calendario/vacaciones",
                data: formData,
                dataType: "text",
                success: function (response) {
                    //console.log(response);
                    if (response == '-1') {
                        ocultarPreloader();
                        basicAlert('Atención', 'Hay 1 o más dias que coinciden con dias ya seleccionados anteriormente, compruebelos antes de volver a elegir los dias que desee, muchas gracias.', 'warning');
                    } else {
                        calendar.removeAllEvents();
                        $.ajax({
                            type: "post",
                            url: "/editar/calendario/vacaciones",
                            data: formData,
                            dataType: "json",
                            success: function (response) {
                                //console.log('dias de vacaciones: ', response);
                                response.forEach(element => {
                                    calendar.addEvent({
                                        title: 'Día de vacaciones',
                                        start: element.fecha_inicio,
                                        end: element.fecha_fin,
                                        color: 'red'
                                    });
                                });
                                $("#añadirFecha").modal("toggle");
                                $("#calendarModal").modal("toggle");
                                $('#calendarModal').on('shown.bs.modal', function () {

                                    calendar.render();
                                });
                                ocultarPreloader();
                            }
                        });
                    }


                }
            });
        } else {
            ocultarPreloader();
            basicAlert('Atención', 'Ambos campos deben estar rellenos con una fecha, comprueba que este todo correcto por favor', 'warning')
        }

    });
    $('.cerrarVacaciones').on('click', function () {
        $("#fechaFin").datepicker("destroy");
        $("#fechaInicio").datepicker("destroy");
        $('#fechaFin').hide();

        $("#calendarModal").modal("toggle");
        //calendar.removeAllEvents();
    });

    $('#btnAgregarEvento').on('click', function () {
        $('#fechaInicio').val("");
        $('#fechaFin').val("");
        $("#fechaInicio").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: fechaActualString
        });
    });
    $('#btnEliminarEvento').on('click', function () {
        $('.eliminardias').empty();
        var formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            dni: dni
        };
        $('#calendarModal').modal('toggle');
        mostrarPreloader();
        $.ajax({
            type: "post",
            url: "/editar/calendario/vacaciones",
            data: formData,
            dataType: "json",
            success: function (response) {
                response.forEach(element => {
                    console.log(element);
                    $('.eliminardias').append('<div class="col-4 ho"><h3>vacaciones</h3><p>' + element.fecha_inicio + '</p><p>' + element.fecha_fin + '</p><input type="hidden" name="id" value="' + element.id + '"></div>');
                });
                ocultarPreloader();

                $('#eliminarFecha').modal('toggle');
            }
        });
    });

    $('#submitEliminarVacaciones').on('click', function () {
        var arrayDiasEliminados = [];
        var diaS = $('.eliminardias').children();
        for (let i = 0; i < diaS.length; i++) {
            const element = diaS.eq(i);
            if (!$(element).hasClass('ho')) {
                arrayDiasEliminados.push(element.find('input').val());
            }
        }
        if (arrayDiasEliminados.length == 0) {
            basicAlert("Atención", "No ha seleccionado ningun dia por favor seleccione al menos una fecha", "warning");
        } else {
            Swal.fire({
                title: "¡Atención!",
                html: "¿Estas seguro de los dias seleccionados?",
                icon: "warning",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
            }).then((result) => {
                if (result.isConfirmed) {
                    mostrarPreloader();
                    var formData = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        dni: dni,
                        dias: arrayDiasEliminados
                    };
                    $.ajax({
                        type: "post",
                        url: "/delete/calendario/vacaciones",
                        data: formData,
                        dataType: "json",
                        success: function (response) {
                            console.log(response.success);
                            ocultarPreloader();
                            if (response.success == 0) {
                                basicAlert('Correcto', 'Dias eliminados con exito!', 'success');
                                Swal.fire({
                                    title: "Correcto",
                                    html: "Dias eliminados con exito!",
                                    icon: "success",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showCancelButton: false,
                                    confirmButtonText: 'Volver al calendario',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        mostrarPreloader();
                                        calendar.removeAllEvents();
                                        $.ajax({
                                            type: "post",
                                            url: "/editar/calendario/vacaciones",
                                            data: formData,
                                            dataType: "json",
                                            success: function (response) {
                                                response.forEach(element => {
                                                    calendar.addEvent({
                                                        title: 'Día de vacaciones',
                                                        start: element.fecha_inicio,
                                                        end: element.fecha_fin,
                                                        color: 'red'
                                                    });
                                                });
                                                $("#eliminarFecha").modal("toggle");
                                                $("#calendarModal").modal("toggle");
                                                $('#calendarModal').on('shown.bs.modal', function () {

                                                    calendar.render();
                                                });
                                                ocultarPreloader();
                                            }
                                        });
                                    }
                                });
                            } else {
                                //mensaje de error y lo mandamos de vuelta al calendario
                                basicAlert('Error', 'Ha ocurrido un error en la transaccion de datos, por favor contacte con el equipo, muchas gracias.', 'error');
                                $("#eliminarFecha").modal("toggle");
                                $("#calendarModal").modal("toggle");
                            }
                        }
                    });
                }
            });
        }

    });
    $(document).on('click', '.eliminardias>.col-4', function () {
        if ($(this).hasClass('ho')) {
            $(this).removeClass('ho');
        } else {
            $(this).addClass('ho');
        }
    });

    $('.adduser').on('click', function () {
        $("#adduser").modal("toggle");
        $("#adduserForm").find("input.form-control").val("");
    });
    $('.cerrarUser').on('click', function () {
        $("#adduser").modal("toggle");
    });
    $('#submitadduser').on('click', function () {

        var formulario = $("#adduserForm");

        var datos = formulario.serialize();
        var fields = formulario.find('input[type="text"], input[type="password"],input[type="tel"],input[type="email"]');
        var isFormValid = true;
        fields.each(function () {
            let field = $(this);

            if (field.val() == '' || field.val() == null) {
                //console.log(field);
                isFormValid = false;
                field.addClass('is-invalid'); // Agregar clase 'is-invalid' para resaltar campos vacíos

            } else {

                field.removeClass(
                    'is-invalid'); // Eliminar clase 'is-invalid' si el campo no está vacío

            }

        });
        if (!validator.isEmail($('#emailAdd').val())) {
            isFormValid = false;
            $('#emailAdd').addClass('is-invalid');
            $('#emailAdd').tooltip('show');
        }
        let result = zxcvbn($('#contrasenia').val());

        if (result.score < 3) {
            isFormValid = false;
            $('#contrasenia').addClass('is-invalid');
            $('#contrasenia').tooltip('show');
        }

        if (isFormValid) {
            $('#errorMessageAdd').hide();
            var formData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                dni: $("#dniAdd").val(),
                identificacion: $("#identificacion").val()
            };
            mostrarPreloader();
            $.ajax({
                type: "post",
                url: "/check/dni",
                data: formData,
                dataType: "text",
                success: function (response) {
                    console.log(response);
                    if (response == "true") {
                        ocultarPreloader();
                        basicAlert("Nº de DNI duplicado", "El número del DNI esta duplicado para este trabajador que instentas introducir, comprueba que primero lo has dado de baja por favor. Si el problema persiste contacte con el servicio técnico, muchas gracias.", "error");
                    } else {

                        $.ajax({
                            type: "post",
                            url: "/add/trabajador",
                            data: datos,
                            dataType: "text",
                            success: function (response) {
                                ocultarPreloader();
                                console.log(response);
                                $("#adduser").modal("toggle");
                                vaciarYRellenarTabla("Completado", "!Se ha dado de alta al usuario!", "success");
                            },
                            error: function (error) {
                                // Manejo de errores
                                ocultarPreloader();
                                console.log(error);
                                basicAlert("Email duplicado", "El email introducido es erroneo o esta duplicado en algún usuario activo, por favor comprueba que los datos son correctos. Si el problema persiste contacte con el servicio técnico, muchas gracias.", "error");

                            }
                        });
                    }
                }
            });

        } else {
            $('#errorMessageAdd').show();
        }

    });
    $(".dash-icon-hover>div").hover(function () {
        // over
        $(this).tooltip('show');
    }, function () {
        // out
        $(this).tooltip('hide');
    }
    );
    $('#excelTrabajadores').click(function (e) {
        e.preventDefault();
        mostrarPreloader();
        $.ajax({
            url: '/get/excel/trabajadores',
            type: 'GET',
            xhrFields: {
                responseType: 'blob' // Establece el tipo de respuesta esperado como Blob
            },
            success: function (blob) {

                // Crea un enlace temporal para descargar el archivo
                const url = window.URL.createObjectURL(new Blob([blob]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'archivo_personalizado.xlsx');
                document.body.appendChild(link);
                link.click();
                // Elimina la URL del Blob para liberar recursos
                window.URL.revokeObjectURL(url);
                ocultarPreloader();
            },
            error: function (error) {
                ocultarPreloader();
                basicAlert("Error!", "Ha ocurrido un error con la descarga del archivo, por favor recarga la pagina. Si no funciona contacte con el equipo técnico", "error");
                console.log('Error en la descarga del archivo:', error);
            }
        });
    });
    $('#recibirEmailTrabajador').click(function (e) {
        e.preventDefault();
        mostrarPreloader();
        $.ajax({
            url: '/send/pdf/trabajadores',
            type: 'GET',
            datatype: 'json',
            success: function (response) {
                console.log(response);
                //ocultarPreloader();
                Swal.fire({
                    title: "Lista enviada con exito!",
                    icon: "success"
                })
            },
            error: function (error) {
                ocultarPreloader();
                basicAlert("Error!", "Ha ocurrido un error con la descarga del archivo, por favor recarga la pagina. Si no funciona contacte con el equipo técnico", "error");
                console.log('Error en el envio del email:', error);
            }
        });

    });
    $("#enviarEmailTrabajador").click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Enviar a:',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            inputPlaceholder:"Email",
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                console.log(login);
                var formData = {
                    email: login,
                };
                mostrarPreloader();
                $.ajax({
                    type: "get",
                    url: "/send/pdf/trabajadores",
                    data: formData,
                    dataType: "text",
                    success: function (response) {
                        Swal.fire({
                            title: "Lista enviada con exito!",
                            icon: "success"
                        })
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                
            }
        })
    });
    $('#dashboard').click(function (e) { 
        e.preventDefault();
        mostrarPreloader("Volviendo al menú","Un momento porfavor.");
        window.location.href="dashboard";
    });
    
});