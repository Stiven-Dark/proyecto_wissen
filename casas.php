<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Casas en Venta - La Finca de Carhuaz</title>
  <link rel="icon" href="assets/img/LOGO2.png" type="image/png" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/header2.css">
  <link rel="stylesheet" href="css/casas.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HEADER DINÁMICO -->
  <?php include'components/header.php'?>

  <!-- HERO DE CASAS -->
    <section class="hero-casas">
      <div class="hero-wrapper">
        <h1>Casas Vivienda Girasol</h1>
        <p>Ideal para quienes desean vivir con estilo y luz natural en cada rincón.</p>
      </div>
    </section>

  <!-- DETALLE DE CASA -->
  <section class="detalle-casa container">
    <div class="detalle-grid">
      <div class="detalle-media">
        <img src="assets/img_casa/FINCAS_CARHUAZ/1.jpg" alt="Casa en Carhuaz" />
      </div>
      <div class="detalle-info">
       <!-- <h2>Casa Vivienda Girasol</h2>
        <p class="concepto">Ideal para quienes desean vivir con estilo y luz natural en cada rincón.</p>-->
        <ul class="detalles-lista">
          <li><strong>Ubicación:</strong> Urb. Las Dunas de Carhuaz</li>
          <li><strong>Área Construida:</strong> 120 m²</li>
          <li><strong>Distribución:</strong> Sala-Comedor, Cocina, Dormitorio, SS.HH, Patio Posterio, Lavanderia</li>
          <li><strong>Servicios:</strong> Agua, luz, desagüe</li>
        </ul>
      <div class="precio-box">
        <p class="precio-label">Precio desde:</p>
        <p class="precio-monto">S/ <span>105,000</span></p>
        <p class="precio-inicial">Con Incial del <strong>20%</strong></p>
      </div>

</div>

        </div>
      </div>
    </div>
  </section>

  <!-- Puedes duplicar la sección anterior para más casas -->

    <section class="galeria-vivienda">
    <div class="miniaturas">
        <img src="assets/img_casa/FINCAS_CARHUAZ/5.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
        <img src="assets/img_casa/FINCAS_CARHUAZ/8.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/FINCAS_CARHUAZ/10.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/FINCAS_CARHUAZ/12.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/FINCAS_CARHUAZ/15.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/FINCAS_CARHUAZ/32.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />

    </div>

    <div class="imagen-grande">
        <img id="imagenPrincipal" src="assets/img_casa/FINCAS_CARHUAZ/5.jpg" alt="Imagen seleccionada" />
    </div>
    </section>



  <!-- FOOTER DINÁMICO -->
  <?php include'components/footer.php'?>

  <script src="js/load-components.js"></script>
  <script src="js/main.js"></script>
</body>

<script>
function mostrarImagen(elemento) {
  const imagen = document.getElementById("imagenPrincipal");
  imagen.classList.add("fade");
  setTimeout(() => {
    imagen.src = elemento.src;
    imagen.alt = elemento.alt;
    imagen.classList.remove("fade");
  }, 300); // mismo tiempo que el CSS
}
</script>



</html>
