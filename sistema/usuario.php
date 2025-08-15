<?php
require_once 'bd/conexion2.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>GESTION DE USUARIOS</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <!-- CSS Just for demo purpose, don't include it in your project -->
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
                <h3 class="fw-bold mb-3">Gestion de Usuarios</h3>
                <h6 class="op-7 mb-2">En esta apartado gestionamos clientes</h6>
              </div>
                          <!-- BOTÓN AGREGAR - NUEVA FUNCIONALIDAD -->
              <div class="ms-md-auto py-2 py-md-0">
                <button type="button" id="btnAbrirModal" class="btn btn-success btn-sm">
                  <i class="fas fa-plus"></i> Agregar Usuario
                </button>
              </div>
            </div>
                          <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Multi Filter Select</h4>
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
                            <th>correo</th>
                            <th>Telefono</th>
                            <th>rol</th>
                            <th>Creado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>correo</th>
                            <th>Telefono</th>
                            <th>rol</th>
                            <th>Creado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php 
                            $sql="SELECT u.id, u.nombre, u.correo, u.telefono, r.nombre_rol, u.rol, u.fecha_creacion, u.estado,
                                  CASE 
                                  WHEN u.estado='1' THEN 'Activo' 
                                  ELSE 'Inactivo' 
                                  END AS status_usuario
                                  FROM usuarios u 
                                  INNER JOIN tipo_rol r ON u.rol=r.id_rol
                                  ";
                            $stmt=$conn->prepare($sql);
                            $stmt->execute();
                            $usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($usuarios AS $usuario)
                            {
                              echo "<tr>";
                                echo "<td>{$usuario['id']}</td>";
                                echo "<td>{$usuario['nombre']}</td>";
                                echo "<td>{$usuario['correo']}</td>";
                                echo "<td>{$usuario['telefono']}</td>";
                                echo "<td>{$usuario['nombre_rol']}</td>";
                                echo "<td>{$usuario['fecha_creacion']}</td>";
                                if ($usuario['status_usuario']== "Activo"){
                                  echo '<td><span style="background-color: #2ecc71; color: #fff; padding: 5px 10px; border-radius: 4px;">Activo</span></td>';
                                }else {
                                  echo '<td><span style="background-color: #e74c3c; color: #fff; padding: 5px 10px; border-radius: 4px;">Inactivo</span></td>';
                                }
                                echo "<td>";
                                  echo "<a href='#' data-id='".$usuario['id']."' class='btn btn-sm btn-warning btn-edit me-1'><i class='icon-pencil'></i></a>";
                                  // adentro del parentesis que deberia colocarse? LA LOGICA, SI LA LOGICA EL VERDAD DONDE DEBO COLOCAR ESA LOGICA -> DENTRO {}
                                  if($usuario['estado']=='1'){
                                    echo "<a href='#' data-id='".$usuario['id']."' class='btn btn-sm btn-danger btn-delete'><i class='icon-trash'></i></a>";
                                  }else{
                                    echo "<a href='#' data-id='".$usuario['id']."' class='btn btn-sm btn-success btn-active'><i class='icon-check'></i></a>";
                                  }
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

        <?php include'layouts/footer.php';?>
      </div>

      <?php include 'modales/usuario/modal_agregar.php'?>
      <?php include 'layouts/configuracion.php';?>

    </div>
    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        var table = $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    // Si la columna es la de acciones, evitamos poner filtro
                    if (index === 7) { // la última columna (Acciones)
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
                    targets: [6], // índice de la columna Estado
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

        //SCRIPT PARA ACTIVAR O ELIMINAR
        $(document).on('click','.btn-delete',function(e){
          e.preventDefault(); // cancela la accion normal del html
          
          var id=$(this).data('id');

          //condicional para saber si estoy recibiendo un tipo de id
          if(!id || isNaN(id) || Number(id) <= 0){
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID de usuario no válido'
          });
            return;
          }
        
          Swal.fire({
            title: '¿Está seguro?',
            text: 'Esta acción desactivará al usuario del sistema',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, desactivar usuario',
            cancelButtonText: 'Cancelar'
          }).then((result)=>{
              if(result.isConfirmed){
                  cambiarEstadoUsuario(id,0,'desactivar');
              }
          });
        });

        $(document).on('click','.btn-active',function(e){
          e.preventDefault(); // cancela la accion normal del html
          
          var id=$(this).data('id');

          //condicional para saber si estoy recibiendo un tipo de id
          if(!id || isNaN(id) || Number(id) <= 0){
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID de usuario no válido'
          });
            return;
          }
        
          Swal.fire({
            title: '¿Está seguro?',
            text: 'Esta acción activara al usuario del sistema',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, desactivar usuario',
            cancelButtonText: 'Cancelar'
          }).then((result)=>{
              if(result.isConfirmed){
                  cambiarEstadoUsuario(id,1,'activar');
              }
          });
        });       
        
        function cambiarEstadoUsuario(id, nuevoEstado, accion){
          $.ajax({
              url: 'acciones/usuario/cambiar_estado.php',
              type: 'POST',
              dataType: 'json',
              data: {
                  id: id,
                  estado: nuevoEstado
              },
              success: function(response) {
                  if (response.status === 'success') {
                      Swal.fire({
                          icon: 'success',
                          title: '¡Estado actualizado!',
                          text: response.message
                      }).then(() => {
                          location.reload();
                      });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: response.message
                      });
                  }
              },
              error: function(xhr, status, error) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error de conexión',
                      text: 'No se pudo ' + accion + ' el usuario'
                  });
              }
          });
      }
      });

      $('#btnAbrirModal').on('click', function() {
      $('#modalAgregarTipoDoc').modal('show');
        });

    </script>
    
  </body>
</html>
