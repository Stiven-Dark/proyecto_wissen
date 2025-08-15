<?php
require_once 'bd/conexion2.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>GESTION DE TIPOS DE DOCUMENTOS</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">

<?php include'layouts/sidebar.php'; ?>

      <div class="main-panel">
        <div class="main-header">
          
<?php include'layouts/header.php';?>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Gestión de Tipos de Documentos</h3>
                <h6 class="op-7 mb-2">En este apartado gestionamos los tipos de documentos</h6>
              </div>
              <!-- BOTÓN AGREGAR - NUEVA FUNCIONALIDAD -->
              <div class="ms-md-auto py-2 py-md-0">
                <button type="button" id="btnAbrirModal" class="btn btn-success btn-sm">
                  <i class="fas fa-plus"></i> Agregar Tipo de Documento
                </button>
              </div>
            </div>
            
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Listado de Tipos de Documentos</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="multi-filter-select"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php 
                            $sql="SELECT id, nombre, 
                                    case 
                                        WHEN estado=1 THEN 'Activo'
                                        ELSE 'Inactivo'
                                        END AS estatus_documento
                                          FROM tipo_documento WHERE estado='1' ";
                            $stmt=$conn->prepare($sql);
                            $stmt->execute();
                            $tipos_documento=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($tipos_documento AS $tipo_documento)
                            {
                                echo "<tr>";
                                echo "<td>{$tipo_documento['id']}</td>";
                                echo "<td>{$tipo_documento['nombre']}</td>";
                                if ($tipo_documento['estatus_documento']== "Activo"){
                                  echo '<td><span style="background-color: #2ecc71; color: #fff; padding: 5px 10px; border-radius: 4px;">Activo</span></td>';
                                }else {
                                  echo '<td><span style="background-color: #e74c3c; color: #fff; padding: 5px 10px; border-radius: 4px;">Inactivo</span></td>';
                                }
                                echo "<td>";
                                echo "<a href='#' data-id='".$tipo_documento['id']."' class='btn btn-sm btn-warning btn-edit me-1'><i class='icon-pencil'></i></a>";
                                echo "<a href='#' data-id='".$tipo_documento['id']."' class='btn btn-sm btn-danger btn-delete'><i class='icon-trash'></i></a>";
                                echo "</td>";
                                echo "</tr>";                              
                            };
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>

<?php include 'modales/tipo_documento/modal_agregar.php'?>
<?php include 'modales/tipo_documento/modal_editar.php' ?>
<?php include 'layouts/footer.php';?>
      </div>

      <?php include'layouts/configuracion.php';?>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>

    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    
    <script>
      $(document).ready(function () {
        // INICIALIZACIÓN DE DATATABLES
        var table = $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    // Si la columna es la de acciones, evitamos poner filtro
                    if (index === 3) { // la última columna (Acciones)
                        return;
                    }
                    
                    var select = $('<select class="form-select"><option value="">Todos</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on("change", function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? "^" + val + "$" : "", true, false).draw();
                        });

                    // Para el resto de columnas, extraemos los valores únicos
                    var valueSet = new Set();
                    column.nodes().each(function(cell) {
                        // Obtenemos solo el texto de la celda, sin HTML
                        var textValue = $(cell).text().trim();
                        if (textValue) {
                            valueSet.add(textValue);
                        }
                    });
                    
                    // Convertimos el Set a Array, ordenamos y agregamos como opciones
                    Array.from(valueSet).sort().forEach(function(text) {
                        select.append('<option value="' + text + '">' + text + '</option>');
                    });
                });
            },
            columnDefs: [
                {
                    // Para la columna de Estado
                    targets: [2], // índice de la columna Estado
                    render: function(data, type, row) {
                        // Solo para búsqueda y ordenamiento, devolvemos el texto puro
                        if (type === 'filter' || type === 'sort') {
                            return $(data).text().trim();
                        }
                        // Para la visualización, mantenemos el HTML original
                        return data;
                    }
                }
            ],
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar MENU registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del START al END de un total de TOTAL registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de MAX registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        // EVENTO ABRIR MODAL AGREGAR
        $('#btnAbrirModal').on('click', function() {
            $('#modalAgregarTipoDoc').modal('show');
        });

        // EVENTO ELIMINAR (código existente mejorado)
        $(document).on('click','.btn-delete', function(e){
            e.preventDefault();
            var id=$(this).data('id');
            console.log('ID a eliminar:', id);
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará este tipo de documento de tu registro.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result)=>{
                console.log('Usuario confirmó eliminación');  
                if(result.isConfirmed){
                    $.ajax({
                        url: 'acciones/tipo_documento/eliminar.php', 
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id},
                        beforeSend: function() {
                            console.log('Enviando petición AJAX...'); 
                        },
                        success: function(response) {
                            console.log('Respuesta del servidor:', response);
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    text: response.message,
                                    confirmButtonColor: '#28a745'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonColor: '#d33'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error AJAX:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de conexión',
                                text: 'Error: ' + error + ' (Código: ' + xhr.status + ')',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        });

        // LIMPIAR FORMULARIO AL CERRAR MODAL
        $('#modalAgregarTipoDoc').on('hidden.bs.modal', function () {
            $('#formAgregarTipoDoc')[0].reset();
        });
           
      });


    </script>

  </body>
</html>