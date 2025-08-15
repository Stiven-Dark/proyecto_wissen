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
</head>
<body>

  <!-- HEADER DINÁMICO -->
  <?php include'components/header.php' ?>

  <!-- HERO DE CASAS -->
  <section class="hero-casas">
      <div class="hero-wrapper">
      <h1>Casas Vivienda Rosas</h1>
      <p>Ideal para quienes valoran la comodidad, el diseño moderno y espacios pensados para disfrutar cada momento en casa.</p>
    </div>
  </section>

  <!-- DETALLE DE CASA -->
  <section class="detalle-casa container">
    <div class="detalle-grid">
      <div class="detalle-media">
        <img src="assets/img_casa/casa2/portada.jpg" alt="Casa en Carhuaz" />
      </div>
      <div class="detalle-info">
       <!-- <h2>Casa Vivienda Rosas</h2>
        <p class="concepto">Ideal para quienes valoran la comodidad, el diseño moderno y espacios pensados para disfrutar cada momento en casa.</p>-->
        <ul class="detalles-lista">
          <li><strong>Ubicación:</strong> Urb. Las Dunas de Carhuaz, Primera Etapa - Av. Santa Rosa</li>
          <li><strong>Área Construida:</strong> 120 m²</li>
          <li><strong>Distribución:</strong> Sala-Comedor, 2 Dormitorios, Cocina, SS.HH, Lavanderia</li>
          <li><strong>Servicios:</strong> Agua, luz, desagüe</li>
        </ul>
        <div class="precio-box">
        <p class="precio-label">Precio desde:</p>
        <p class="precio-monto">S/ <span>130,000</span></p>
        <p class="precio-inicial">Con Incial del <strong>20%</strong></p>
      </div>
      </div>
    </div>
  </section>

  <!-- Puedes duplicar la sección anterior para más casas -->

    <section class="galeria-vivienda">
    <div class="miniaturas">
        <img src="assets/img_casa/casa2/1.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
        <img src="assets/img_casa/casa2/2.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
        <img src="assets/img_casa/casa2/3.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
        <img src="assets/img_casa/casa2/4.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
        <img src="assets/img_casa/casa2/5.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
    </div>

    <div class="imagen-grande">
        <img id="imagenPrincipal" src="assets/img_casa/casa2/5.jpg" alt="Imagen seleccionada" />
    </div>
    </section>



  <!-- FOOTER DINÁMICO -->
  <?php include'components/footer.php' ?>

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
