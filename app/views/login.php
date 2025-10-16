<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de sesión</title>
  <link href="/scss/custom.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <section class="container-fluid p-0">
    <div class="row g-0">
      <!-- Columna izquierda -->
      <div class="col-sm-6 col-12 vh-100 bg-primary text-white d-flex justify-content-center align-items-center">
        <div class="w-75"> <!-- Controla el ancho del formulario -->
          <h1 class="mb-4 text-center">Inicio de sesión</h1>
          <form id="login">
            <div id="alert" style="display: none;" class="alert alert-danger" role="alert">
              Usuario o contraseña incorrectos
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico:</label>
              <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="ejemplo@correo.com">
            </div>
            <div class="mb-3">
              <label for="pass" class="form-label">Contraseña:</label>
              <input type="password" class="form-control form-control-lg" id="pass" name="pass" placeholder="••••••••">
            </div>
            <button type="submit" class="btn btn-success w-100 mt-2 btn-lg" id="entrar">Entrar</button>
          </form>
        </div>
      </div>

      <!-- Columna derecha -->
      <div class="col-sm-6 col-12 vh-100 bg-white d-flex justify-content-center align-items-center">
        <img src="https://img.freepik.com/vector-gratis/cola-supermercado-distancia-seguridad_52683-38160.jpg" alt="Imagen decorativa" class="img-fluid">
      </div>
    </div>
  </section>

  <script>
    document.getElementById("entrar").addEventListener("click", function(event) {
      event.preventDefault()
      const email = document.getElementById("email").value
      const pass = document.getElementById("pass").value

      const data = {
        email: email,
        pass: pass
      };

      fetch(
          'http://sistema-ventas.test/apisesion', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          })
        .then(response => response.json())
        .then(responseData => {
          if (responseData === true) {
            document.getElementById("alert").style.display = "none";
            window.location.href = "/inicio"
          } else {
            document.getElementById("alert").style.display = "block";

          }
        })
        .catch(error => console.error('Error:', error));
    })
  </script>
</body>

</html>