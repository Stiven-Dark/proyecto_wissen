<?php
require_once'bd/conexion2.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>GESTION DE CLIENTES</title>
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
                <h3 class="fw-bold mb-3">Gestion de Clientes</h3>
                <h6 class="op-7 mb-2">En esta apartado gestionamos clientes</h6>
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
                            <th>Apellido</th>
                            <th>Edad</th>
                            <th>Ciudad</th>
                            <th>Provincia</th>
                            <th>Departamento</th>
                            <th>Tipo de Documento</th>
                            <th>Telefono</th>
                            <th>DNI</th>
                            <th>Interes</th>
                            <th>Asersor</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Edad</th>
                            <th>Ciudad</th>
                            <th>Provincia</th>
                            <th>Departamento</th>
                            <th>Tipo de Documento</th>
                            <th>Telefono</th>
                            <th>DNI</th>
                            <th>Interes</th>
                            <th>Asersor</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php 
                            $sql="SELECT id, nombre, apellido, edad, ciudad, provincia, departamento, tipo_documento, telefono, dni, interes, asesor_id, estado, fecha_registro FROM clientes";
                            $stmt=$conn->prepare($sql);
                            $stmt->execute();
                            $clientes=$stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($clientes AS $cliente)
                            {
                              echo "<tr>";
                                echo "<td>{$cliente['id']}</td>";
                                echo "<td>{$cliente['nombre']}</td>";
                                echo "<td>{$cliente['apellido']}</td>";
                                echo "<td>{$cliente['edad']}</td>";
                                echo "<td>{$cliente['ciudad']}</td>";
                                echo "<td>{$cliente['provincia']}</td>";
                                echo "<td>{$cliente['departamento']}</td>";
                                echo "<td>{$cliente['tipo_documento']}</td>";
                                echo "<td>{$cliente['telefono']}</td>";
                                echo "<td>{$cliente['dni']}</td>";
                                echo "<td>{$cliente['interes']}</td>";
                                echo "<td>{$cliente['asesor_id']}</td>";
                                echo "<td>{$cliente['estado']}</td>";
                                echo "<td>{$cliente['fecha_registro']}</td>";
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

      <?php include'layouts/configuracion.php';?>

    </div>
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
      });
    </script>
    
  </body>
</html>
