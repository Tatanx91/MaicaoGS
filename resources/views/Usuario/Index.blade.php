@extends('layout.home')

@section('content')

<header>
        <div class="container">
          <div class="brand">
            <h1 class="brand_name"><a href="./">Maicao Gift Store</a></h1>
            <p class="brand_slogan">Imagen de la compañia</p>
            <img src="{{asset('Imagenes/hasbro.png')}}" style="width: 128px; height: 128px" />
          </div>
        </div>

        <!--
        <div id="stuck_container" class="stuck_container">
          <div class="container">
            <nav class="nav">
              <ul data-type="navbar" class="sf-menu">
                <li class="active"><a href="./">Home</a>
                </li>
                <li><a href="index-1.html">About</a>
                  <ul>
                    <li><a href="#">Lorem ipsum dolor</a></li>
                    <li><a href="#">Conse ctetur adipisicing</a></li>
                    <li><a href="#">Elit sed do eiusmod
                        <ul>
                          <li><a href="#">Lorem ipsum</a></li>
                          <li><a href="#">Conse adipisicing</a></li>
                          <li><a href="#">Sit amet dolore</a></li>
                        </ul></a></li>
                    <li><a href="#">Incididunt ut labore</a></li>
                    <li><a href="#">Et dolore magna</a></li>
                    <li><a href="#">Ut enim ad minim</a></li>
                  </ul>
                </li>
                <li><a href="index-2.html">Services</a>
                </li>
                <li><a href="index-3.html">FAQS</a>
                </li>
                <li><a href="index-4.html">Contacts</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        -->
        <div id="Login">
            <form action="Create.blade.php" method="post">
                Usuario: <input type="text" name="Usuario"><br>
                Contraseña: <input type="text" name="Contraseña"><br>
                <input type="submit">
            </form>
        </div>

      </header>
      
    <script src="{{asset('js/<script></script>.js ')}}" ></script>

@endsection