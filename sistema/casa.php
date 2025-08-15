<?php
require_once'bd/conexion2.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>GESTION DE CASAS</title>
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

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">

<?php include 'layouts/sidebar.php'; ?>

      <div class="main-panel">
        <div class="main-header">
          
<?php include 'layouts/header.php';?>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Gestion de Casas</h3>
                <h6 class="op-7 mb-2">En esta apartado gestionamos clientes</h6>
              </div>
              <!-- BOTÓN AGREGAR - NUEVA FUNCIONALIDAD -->
              <div class="ms-md-auto py-2 py-md-0">
                <button type="button" id="btnAbrirModal" class="btn btn-success btn-sm">
                  <i class="fas fa-plus"></i> Agregar Tipo de Casa
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
                                    CASE 
                                        WHEN estado='1' THEN 'Activo'
                                        END AS estatus_casa FROM tipo_casa  WHERE estado='1'
                             ";
                            $stmt=$conn->prepare($sql);
                            $stmt->execute();
                            $tipos_casa=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($tipos_casa AS $tipo_casa)
                            {
                              echo "<tr>";
                                echo "<td>{$tipo_casa['id']}</td>";
                                echo "<td>{$tipo_casa['nombre']}</td>";
                                if ($tipo_casa['estatus_casa']=="Activo"){
                                        echo '<td><span style="background-color: #2ecc71; color: #fff; padding: 5px 10px; border-radius: 4px;">Activo</span></td>';
                                }else {
                                        echo '<td><span style="background-color: #e74c3c; color: #fff; padding: 5px 10px;   border-radius: 4px;">Inactivo</span></td>';
                                }
                                echo "<td>";
                                    echo "<a href='#' data-id='".$tipo_casa['id']."' class='btn btn-sm btn-warning btn-edit me-1'><i class='icon-pencil'></i></a>";
                                    echo "<a href='#' data-id='".$tipo_casa['id']."' class='btn btn-sm btn-danger btn-delete'><i class='icon-trash'></i></a>";
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

      <?php include 'modales/tipo_casa/modal_agregar.php'?>
      <?php include 'modales/tipo_casa/modal_editar.php'?>
      <?php include 'layouts/footer.php';?> 
      </div>

      <?php include 'layouts/configuracion.php';?>

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
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
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
                        url: 'acciones/tipo_casa/eliminar.php', 
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