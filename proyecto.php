<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Urb. Las Dunas - Proyecto</title>
  <link rel="icon" href="assets/img/LOGO2.png" type="image/png" />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="css/header2.css">
  <link rel="stylesheet" href="/css/proyecto.css" />
</head>

<!-- Carrusel Superior -->
<section class="carousel-top">
  <div class="carousel-slide active">
    <img src="assets/proyecto/images.jpg" alt="Imagen 1" />
  </div>
  <div class="carousel-slide">
    <img src="assets/proyecto/portada2.jpg" alt="Imagen 2" />
  </div>
</section>


<body>

  <!-- HEADER -->
<?php include'components/header.php' ?>

  <!-- Hero del Proyecto -->
  <section class="proyecto-hero">
    <div class="proyecto-info">
      <h1>URBANIZACIÓN LAS DUNAS</h1>
      <p class="ubicacion"><i class="icon-location"></i> Av. Juan Pablo Fernandini 312, Ica</p>
      <p class="horario"><i class="icon-clock"></i> Lunes a Viernes de 9:00 AM - 6:00 PM</p>
      <p class="horario"><i class="icon-clock"></i> Sábados de 9:00 AM - 1:00 PM</p>
    </div>
    <div class="precio-destacado">
  <div class="precio-box">
    <p class="desde">Precio desde</p>
    <h2>S/ 560</h2>
    <p class="mes">al mes</p>
  </div>
  <!--<p class="pago-contado">
    <img src="assets/icons/billete.png" alt="Tarjeta" />
    Pago al contado: <strong>S/ 62,061</strong>
  </p> -->
</div>

  </section>

  <!-- Descripción -->
  <section class="descripcion">
    <h2>💸 ¡Tu lote propio sin papeleos ni intereses!</h2>
  <p><strong>Accede hoy al proyecto “Las Dunas” con facilidades únicas:</strong><br>
    Contamos con crédito directo <strong>sin requisitos bancarios ni historial crediticio</strong>. Solo necesitas tu DNI para iniciar el proceso.</p>

  <ul>
    <li> <strong>Cuotas mensuales sin intereses</strong></li>
    <li> Sin garantes, sin trámites complejos</li>
    <li> Firma inmediata y asesoría personalizada</li>
    <li> ¡Entrega rápida y 100% segura!</li>
  </ul>

  <p>Vive tranquilo, invierte seguro. <strong>¡Aprovecha esta oportunidad limitada y empieza a construir tu futuro hoy mismo!</strong></p>
</section>

  <!-- Beneficios -->
  <section class="beneficios">
    <h2>Disfruta con todo equipado</h2>
    <div class="beneficios-grid">
      <div class="beneficio"><img src="assets/icons/titulo.png" /><p>Título de Propiedad</p></div>
      <div class="beneficio"><img src="assets/icons/servicios.png" /><p>Servicios completos</p></div>
      <div class="beneficio"><img src="assets/icons/juegos.png" /><p>Juegos para niños</p></div>
      <div class="beneficio"><img src="assets/icons/parque.png" /><p>Parques</p></div>
      <div class="beneficio"><img src="assets/icons/ciclovia.png" /><p>Ciclovía</p></div>
    </div>
  </section>

  <!-- Galería de Video -->
  <section class="galeria">
    <h2>Video</h2>
    <div class="video-container">
      <iframe src="assets/proyecto/proyecto.mp4" frameborder="0" allowfullscreen></iframe>
    </div>
  </section>

  <!-- Mapa -->
  <section class="ubicacion">
    <h2>Ubicación del Proyecto:</h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3678.601145910658!2d-75.8135333!3d-14.071864099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9110e5322d5ec0bd%3A0x10d2f08564d83b31!2sUrb.%20Las%20Dunas%20de%20Carhuaz!5e1!3m2!1ses!2spe!4v1752267041514!5m2!1ses!2spe" 
    width="600" 
    height="450" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade"></iframe>
    <p><i class="icon-location"></i> Km 9.5 de la carretera Carhuaz - Ica</p>
  </section>

  <!-- Descuentos -->
 <!-- <section class="descuentos">
    <h2>🌿 ¡Aprovecha descuentos exclusivos por tiempo limitado!</h2>
    <div class="descuentos-grid">
      <div class="card-descuento">
        <h3>💰 ¡Descuento de $1,100!</h3>
        <p>por <strong>10%</strong> pago a la firma</p>
      </div>
      <div class="card-descuento">
        <h3>💰 ¡Descuento de $1,800!</h3>
        <p>por <strong>20%</strong> pago a la firma</p>
      </div>
      <div class="card-descuento">
        <h3>💰 ¡Descuento de $2,500!</h3>
        <p>por <strong>pago al contado</strong></p>
      </div>
    </div>
    <small>* Imágenes referenciales. No acumulables. Sujeto a cambios.</small>
  </section>-->

  <!-- FOOTER DINÁMICO -->
  <?php include'components/footer.php' ?>

  <!-- JS para cargar HEADER y FOOTER -->
  <script src="js/load-components.js"></script>
  <script src="js/main.js"></script>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    let paused = false;
    const slides = document.querySelectorAll('.carousel-slide');
    let currentSlide = 0;

    // Pausar al pasar el mouse
    document.querySelector('.carousel-top').addEventListener('mouseenter', () => paused = true);
    document.querySelector('.carousel-top').addEventListener('mouseleave', () => paused = false);

    // Cambiar slide cada 3 segundos si no está pausado
    setInterval(() => {
      if (!paused && slides.length > 1) {
        slides[currentSlide].classList.remove("active");
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add("active");
      }
    }, 3000);
  });
  </script>



</body>
</html>