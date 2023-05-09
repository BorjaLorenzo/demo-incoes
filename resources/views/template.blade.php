<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <title>Dashboard</title>
    <style>
      .dash-icon-hover:hover{
        opacity: 0.8;
        cursor: pointer;
      }
      .dash-icon-hover>div>svg{
        width: 100px;
        height: 100px;
      }
      /* .dash-icon-hover{
        border: solid 1px black;
        border-radius: 25px;
      } */
      .gap-menu{
        gap: 10rem!important;
      }
    </style>
    @bukStyles(true)
</head>
<body>
  
  
      <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary bg-dark " data-bs-theme="dark">
            <div class="container-fluid ">
              <a class="navbar-brand" href="#">INCOES</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Perfil
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="logout">Desconectar</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
          @yield('content')
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
      <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
      <script>
        $(document).ready(function () {
          $('.a-click').click(function (e) { 
            e.preventDefault();
            let id=$( this ).attr('id');
            window.location.href=id;
          });
        });
      </script>
      @bukScripts(true)
</body>
</html>
