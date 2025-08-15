<header class="header">
  <div class="header-container">
    <!-- Logo -->
    <div class="header-left">
      <img src="assets/img/logo.png" alt="La Finca de Carhuaz" class="logo">
    </div>

    <!-- Botón hamburguesa -->
    <button class="hamburger" id="hamburgerBtn">&#9776;</button>

    <!-- Menú de navegación -->
    <nav class="header-center" id="navMenu">
      <ul class="nav-links">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="index.php#proyecto">Proyecto</a></li>
        <li><a href="index.php#casas">Casas</a></li>
        <li><a href="index.php#nosotros">Nosotros</a></li>
      </ul>
    </nav>

    <!-- Botón de contacto -->
    <div class="header-login">
      <a href="login.php" class="boton_login">Login</a>
    </div>

    <div class="header-right">
      <button id="abrirModal" class="btn-header">Contáctanos</button>
    </div>
  </div>
</header>

<script>
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const navMenu = document.getElementById('navMenu');

  hamburgerBtn.addEventListener('click', () => {
    navMenu.classList.toggle('open');
  });
</script>
