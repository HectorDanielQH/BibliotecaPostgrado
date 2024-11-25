@extends('tablar::page')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none px-4">

        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Administración de Facultades
                    </h2>
                </div>
            </div>
        </div>


        <div class="container d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Agregar Facultad
            </button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agrega el nombre de la Facultad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="facultad">Nombre de Facultad</label>
                        <x-input class="mt-3" name="facultad" id="facultad"/>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrar-modal">Cerrar</button>
                <button type="button" class="btn btn-primary"  onclick="Guardar()">Guardar</button>
                </div>
            </div>
            </div>
        </div>


        <!-- Editar -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Edita el nombre de la Facultad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <form>
                                <input type="hidden" name="idfacultad" id="idfacultad" value="">
                                <label for="facultad">Nombre de Facultad</label>
                                <x-input class="mt-3" name="facultadeditar" id="facultadeditar" value=""/>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrar-modal-editar">Cerrar</button>
                    <button type="button" class="btn btn-primary"  onclick="GuardarEditado()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body px-4">
        <div class="container">
            <table class="table table-responsive table-bordered" id="tabla">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre de la Facultad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
@endsection

@section('css')
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/b-print-3.2.0/fc-5.0.4/fh-4.0.1/sp-2.3.3/datatables.min.css" rel="stylesheet">
@stop

@section('js')
    <script 
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>    
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/b-print-3.2.0/fc-5.0.4/fh-4.0.1/sp-2.3.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        let tabla = $('#tabla').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('facultades.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nombre' },
                { data: 'action'}
            ],
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron resultados",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros en total)",
                search: "Buscar:",
                aria: {
                    sortAscending: ": activar para ordenar la columna de manera ascendente",
                    sortDescending: ": activar para ordenar la columna de manera descendente"
                }
            }
        });

        function Guardar() {
            $.ajax({
                url: '{{ route('facultades.store') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    facultad: $('#facultad').val(),
                },
                success: function (response) {
                    tabla.ajax.reload();
                    $('#cerrar-modal').click();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Muestra el error en la consola
                    alert('Ocurrió un error al guardar la facultad');
                }
            });
        }

        //eliminar facultad
        function eliminarFacultad(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, eliminarlo!",
                cancelButtonText:'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("facultades.destroy", ":id") }}'.replace(':id', id),
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            tabla.ajax.reload();
                            Swal.fire({
                                title: "¡Eliminado!",
                                text: "La facultad fue eliminada correctamente.",
                                icon: "success"
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                            alert('Ocurrió un error al eliminar la facultad');
                        }
                    });
                }
            });
        }

        function editarFacultad(id, nombre) {
            $('#idfacultad').val(id);
            $('#facultadeditar').val(nombre);
        }

        function GuardarEditado(){
            let id = $('#idfacultad').val();
            
            $.ajax({
                url: '{{ route('facultades.update', ":id") }}'.replace(':id', id),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _method: 'PUT',
                    facultad: $('#facultadeditar').val(),
                },
                success: function (response) {
                    tabla.ajax.reload();
                    $('#cerrar-modal-editar').click();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Ocurrió un error al editar la facultad');
                }
            });
        }

    </script>
@stop