<?php
require_once'sistema/bd/conexion.php';

/*$tipos_casa=[];
$sql="select id, nombre from tipo_casa";
$resultado=mysqli_query($conexion,$sql);
if ($resultado){
  while($fila=mysqli_fetch_assoc($resultado)){
    $tipos_casa[]=$fila;
  }
  } else{
    echo "Error en el resultado".mysqli_error($conexion);
  }-->

$tipos_documento=[];
$sql="SELECT id, nombre FROM tipo_documento WHERE estado=1";
$resultado=mysqli_query($conexion,$sql);
  if($resultado){
    while($fila=mysqli_fetch_assoc($resultado)){
      $tipos_documento[]=$fila;
    }
    }else {
      echo "Error en el resultado".mysqli_error($conexion);
    }
*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio - La Finca de Carhuaz</title>
  <link rel="icon" href="assets/img/LOGO2.png" type="image/png" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="sistema/css/estilos.css">
  <link rel="stylesheet" href="css/header2.css">
</head>
<body>

  <!-- HEADER DINÁMICO -->
<?php include'components/header.php';?>

    <!-- HERO PRINCIPAL -->
      <section class="hero-centrado">
        <img src="assets/img/portada.jpg" class="hero-bg" alt="Fondo Hero">
        <div class="hero-contenido">
          <div class="hero-texto-logo">
            <div class="texto">
              <center><h1>La Finca de Carhuaz</h1>
                <p>Construimos más que casas, creamos hogares.<br>Haz realidad el sueño de vivir como siempre imaginaste.</p>
            </div>
          </div>
        </div>
      </section>


<!-- TARJETAS DE OPCIONES -->
<section class="opciones-section">
  <div class="container-opciones">
    <div class="opcion-card" onclick="mostrarSeccion('proyectos')">
      <img src="assets/img/proyectos-banner.jpg" alt="Proyectos" />
      <h2>Nuestros Proyectos</h2>
    </div>
    <div class="opcion-card" onclick="mostrarSeccion('casas')">
      <img src="assets/img/casas-banner.jpg" alt="Modelos de Casa" />
      <h2>Modelos de Casa</h2>
    </div>
  </div>
</section>

<!-- CONTENIDO DINÁMICO: Proyectos -->
<section id="seccion-proyectos" class="contenido-dinamico" style="display: none;">
  <h2 class="titulo-seccion">Nuestros Proyectos</h2>
  <div class="projects-grid">
    <div class="project-card">
      <img src="assets/proyecto/proyecto1.png" alt="Proyecto 1" />
      <div class="project-info">
        <h3>LAS DUNAS DE CARHUAZ</h3>
        <p>Carretera Carhuaz - Comatrana - Ica</p>
        <a href="proyecto.php" class="btn-sm">Ver más</a>
      </div>
    </div>
    <div class="project-card">
      <img src="assets/proyecto2/portada.jpg" alt="Proyecto 2" />
      <div class="project-info">
        <h3>PLANICIES DE COSTA SUR</h3>
        <p>Punta Lomitas - Ocucaje - Ica</p>
        <a href="proyecto2.php" class="btn-sm">Ver más</a>
      </div>
    </div>
  </div>
</section>

<!-- CONTENIDO DINÁMICO: Casas -->
<section id="seccion-casas" class="contenido-dinamico" style="display: none;">
  <h2 class="titulo-seccion">Modelos de Casa</h2>
  <div class="casas-grid">
    <div class="casa-card">
      <img src="assets/img_casa/FINCAS_CARHUAZ/1.jpg" alt="Casa 1" />
      <div class="casa-info">
        <h3>Casa Vivienda Girasol</h3>
        <p>Urb. Las Dunas de Carhuaz</p>
        <a href="casas.php" class="btn-casa">Ver más</a>
      </div>
    </div>
    <div class="casa-card">
      <img src="assets/img_casa/casa2/portada.jpg" alt="Casa 2" />
      <div class="casa-info">
        <h3>Casa Vivienda Rosas</h3>
        <p>Urb. Las Dunas de Carhuaz</p>
        <a href="casas2.php" class="btn-casa">Ver más</a>
      </div>
    </div>
    <div class="casa-card">
      <img src="assets/img_casa/casa3/portada.png" alt="Casa 3" />
      <div class="casa-info">
        <h3>Casa Vivienda Esmeralda</h3>
        <p>Urb. Residencial Luisiana</p>
        <a href="casas3.php" class="btn-casa">Ver más</a>
      </div>
    </div>
  </div>
</section>


     <!-- SECCIÓN NOSOTROS -->
  <section id="nosotros" class="nosotros-section">
    <h2>Nosotros</h2>
    <p class="descripcion">
      Somos una empresa con más de 5 años de experiencia en el rubro inmobiliario. Hemos desarrollado múltiples proyectos enfocados en brindar calidad de vida, sostenibilidad y accesibilidad a nuestras familias. Nuestro compromiso es contigo.
    </p>

    <div class="nosotros-wrapper">
      <!-- Carrusel -->
        <div class="carrusel-box" id="carrusel">
          <img src="assets/img/carrusel1.jpg" alt="Imagen 1" class="slide active" />
          <img src="assets/img/carrusel2.jpg" alt="Imagen 2" class="slide" />
          <img src="assets/img/carrusel3.jpg" alt="Imagen 3" class="slide" />
        </div>

      <!-- Contadores -->
      <div class="nosotros-contadores">
        <div class="contador">
          <span class="numero" data-target="5">5
          </span>
          <p>Años de experiencia</p>
        </div>
        <div class="contador">
          <span class="numero" data-target="1000">1000</span>
          <p>Familias satisfechas</p>
        </div>
        <div class="contador">
          <span class="numero" data-target="2">2</span>
          <p>Proyectos ejecutados</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal del formulario -->
  <div id="modal" class="modal">
    <div class="modal-contenido">
      <span class="cerrar">&times;</span>
      
      <!-- NUEVO TÍTULO -->
      <center><h2 style="color: #3E6C3E; font-size: 22px; margin-bottom: 10px;">
        Para mayor información
      </h2></center>

      <!-- NUEVO SUBTEXTO -->
      <p style="text-align: center; margin-top: -10px; margin-bottom: 20px; font-size: 15px;">
        Rellene este formulario y nos pondremos en contacto con usted
      </p>

      <form action="sistema/acciones/clientes/guardar_cliente.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <select name="tipo_documento" required>
          <!--<option value="">Tipo de Documento</option>
          <?php foreach($tipos_documento AS $tipo_doc): ?>
          <option value="<?php echo htmlspecialchars($tipo_doc['id']);  ?>">
          <?php echo htmlspecialchars($tipo_doc['nombre']); ?>
          </option>
          <?php endforeach; ?>
        </select>-->
        <input type="text" name="dni" placeholder="DNI" required 
              pattern="[0-9]{8}" 
              title="El DNI debe tener 8 dígitos"
              maxlength="8">
        <input type="number" name="edad" placeholder="Edad" required>
        <input type="text" name="departamento" placeholder="Departamento" required>
        <input type="text" name="provincia" placeholder="Provincia" required>
        <input type="text" name="ciudad" placeholder="Ciudad" required>
        <input type="text" name="telefono" placeholder="Teléfono" required 
              pattern="[0-9]{9}" 
              title="El número debe tener 9 dígitos"
              maxlength="9"> 

    <!--    <select name="interes" required>
          <option value="">¿Qué busca?</option>
          <?php foreach($tipos_casa AS $tipo): ?>
          <option value="<?php echo htmlspecialchars($tipo['nombre']);  ?>">
          <?php echo htmlspecialchars($tipo['nombre']); ?>
          </option>
          <?php endforeach; ?>
        </select>-->

        <button type="submit" class="btn-guardar">Enviar</button>
      </form>

    </div>
  </div>


  <!-- FOOTER DINÁMICO -->
  <?php include'components/footer.php';?>

  <!-- JS para cargar HEADER y FOOTER -->
  <script src="js/load-components.js"></script>
  <script src="js/main.js"></script>
  <!-- Script del modal -->
  <script src="sistema/js/modal.js"></script>

  <script>
      document.addEventListener("DOMContentLoaded", () => {
      const counters = document.querySelectorAll('.numero');

      counters.forEach(counter => {
        const target = +counter.dataset.target;
        let count = 0;
        const speed = 40; // menor = más rápido

        const updateCounter = () => {
          const increment = Math.ceil(target / speed);
          if (count < target) {
            count += increment;
            if (count > target) count = target;
            counter.innerText = count;
            setTimeout(updateCounter, 30);
          } else {
            counter.innerText = target;
          }
        };

        updateCounter();
        });
      });
  </script>

  <script>
  function mostrarSeccion(seccion) {
    document.getElementById("seccion-proyectos").style.display = (seccion === "proyectos") ? "block" : "none";
    document.getElementById("seccion-casas").style.display = (seccion === "casas") ? "block" : "none";
  }
</script>
  
</body>

</html>