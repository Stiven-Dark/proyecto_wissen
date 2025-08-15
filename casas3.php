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
      <h1>Casa Vivienda Esmeralda</h1>
      <p>Ideal para quienes buscan confort, estilo y amplitud en cada rincón. Casa Vivienda Esmeralda combina modernidad y elegancia en una propuesta de vivienda pensada para el bienestar familiar.</p>
    </div>
  </section>

  <!-- DETALLE DE CASA -->
  <section class="detalle-casa container">
    <div class="detalle-grid">
      <div class="detalle-media">
        <img src="assets/img_casa/casa3/portada.png" alt="Casa en Carhuaz" />
      </div>
      <div class="detalle-info">
       <!-- <h2>Casa Vivienda Esmeralda</h2>
        <p class="concepto">Ideal para quienes buscan confort, estilo y amplitud en cada rincón. Casa Vivienda Esmeralda combina modernidad y elegancia en una propuesta de vivienda pensada para el bienestar familiar.</p>
        <ul class="detalles-lista">-->
          <li><strong>Ubicación:</strong> Urb. Residencia Luisianas</li>
          <li><strong>Área construida:</strong> 120 m²</li>
          <li><strong>Distribución:</strong> Cochera, Estudio, SS.HH, Cocina, Comedor, Sala, Jardin, Dormitoria Principal, 3 Dormitorias Secundarios, Lavanderia, Terraza</li>
          <li><strong>Servicios:</strong> Agua, luz, desagüe</li>
        </ul>
        <div class="precio-box">
          <p class="precio-label">Precio desde:</p>
          <p class="precio-monto">S/ <span>350,000</span></p>
          <p class="precio-inicial">Con Incial del <strong>20%</strong></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Puedes duplicar la sección anterior para más casas -->

    <section class="galeria-vivienda">
    <div class="miniaturas">
        <img src="assets/img_casa/casa3/1.jpg" onclick="mostrarImagen(this)" alt="Casa 1" />
        <img src="assets/img_casa/casa3/2.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/casa3/3.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/casa3/4.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/casa3/5.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
        <img src="assets/img_casa/casa3/6.jpg" onclick="mostrarImagen(this)" alt="Casa 2" />
    </div>

    <div class="imagen-grande">
        <img id="imagenPrincipal" src="assets/img_casa/casa3/1.jpg" alt="Imagen seleccionada" />
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
