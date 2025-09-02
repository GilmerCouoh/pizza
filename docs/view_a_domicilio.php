<?php
// Obtenemos los datos enviados por GET
$pizza_id = $_GET['pizza_id'] ?? null;
$size = $_GET['size'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido a domicilio</title>
    <link rel="stylesheet" href="css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montagu+Slab:opsz@16..144&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    Montagu: ["Montagu Slab"],
                    Montserrat: ["Montserrat"],
                },
            },
        },
    };
    </script>
    <style>
    #map {
      height: 500px;
      width: 100%;
      margin-top: 20px;
    }
    form {
      margin-bottom: 10px;
    }
    </style>
</head>

<body class="bg-[#f6af89] min-h-screen">
    <div>
        <header class="bg-[#f45c33] text-gray-50 font-medium">
            <div class="flex justify-between items-center p-4">
                <div class="flex items-center">
                    <a href="inicio.php">
                        <img src="https://i.postimg.cc/3NY25rCG/logo.png" alt="Logo MariaReyes" class="h-12">
                    </a>
                    <span class="ml-2 text-2xl font-Montagu">Maria Reyes</span>
                </div>

                <nav class="hidden lg:block font-Montserrat">
                    <ul class="flex flex-col lg:flex-row lg:space-x-6 lg:justify-end">
                        <li><a href="view_user.php" class="block py-2 hover:border-b-4 border-b-orange-700">Inicio</a></li>
                        <li><a href="view_menu_pizzas.php" class="block py-2 hover:border-b-4 border-b-orange-700">Menú</a></li>
                        <li><a href="view_pedido.php" class="block py-2 hover:border-b-4 border-b-orange-700">Tu pedido</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Formulario -->
        <form action="view_pedido.php" method="POST"
              class="max-w-xl mx-auto my-7 bg-[#e9e9e9] p-6 rounded-md shadow-lg font-Montserrat" id="pedidoForm">
            <!-- Campos ocultos -->
            <input type="hidden" name="pizza_id" value="<?= htmlspecialchars($pizza_id) ?>">
            <input type="hidden" name="size" value="<?= htmlspecialchars($size) ?>">

            <div class="mb-4">
                <label for="fname" class="block mb-2 font-medium">Nombre</label>
                <input type="text" id="fname" name="fname" class="w-full px-4 py-2 rounded-md bg-[#bebdbd]" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block mb-2 font-medium">Número de teléfono</label>
                <input type="text" id="phone" name="phone" class="w-full px-4 py-2 rounded-md bg-[#bebdbd]" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block mb-2 font-medium">Dirección</label>
                <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 rounded-md bg-[#bebdbd]" required></textarea>
            </div>
            <div class="mb-4">
                <label for="reference" class="block mb-2 font-medium">Referencia</label>
                <textarea id="reference" name="reference" rows="3" class="w-full px-4 py-2 rounded-md bg-[#bebdbd]" required></textarea>
            </div>
            <!-- Mapa de Google -->
        <div id="map" class="max-w-xl mx-auto  rounded-md shadow-lg my-4" ></div>
            <div class="text-center">
                <button type="submit" class="bg-[#ec7433] rounded-md hover:bg-[#f45c33] px-8 py-2 font-bold text-white">
                    Ordenar
                </button>
            </div>
        </form>

        

    </div>

    <!-- Footer -->
    <footer class="bg-[#f45c33] text-gray-50 py-8">
        <div class="container mx-auto text-center">
            <p class="mb-4">© 2024 Maria Reyes Todos los derechos reservados</p>
            <div class="flex justify-center space-x-4 mb-4">
                <a href="https://www.facebook.com/MariaReyespizzeria/?locale=es_LA" class="hover:underline">Facebook</a>
                <a href="https://www.instagram.com/mariareyes7334/" class="hover:underline">Instagram</a>
            </div>
            <div class="flex justify-center space-x-6">
                <a href="#" class="hover:underline">Política de privacidad</a>
                <a href="#" class="hover:underline">Términos de uso</a>
                <a href="#" class="hover:underline">Contacto</a>
            </div>
        </div>
    </footer>

    <!-- Scripts del mapa -->
    <script>
    let map;
    let directionsService;
    let directionsRenderer;

    // Coordenadas fijas 
    const ORIGEN = { lat: 21.090441802922186, lng: -89.29448453037323 };

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: ORIGEN,
        zoom: 13,
      });

      directionsService = new google.maps.DirectionsService();
      directionsRenderer = new google.maps.DirectionsRenderer();
      directionsRenderer.setMap(map);

      // Escuchar cambios en el campo de dirección
      document.getElementById("address").addEventListener("blur", function () {
        calcularRuta();
      });
    }

    function calcularRuta() {
      const destino = document.getElementById("address").value;
      if (destino.trim() === '') return; // No calcular si no hay dirección

      const request = {
        origin: ORIGEN,
        destination: destino,
        travelMode: google.maps.TravelMode.DRIVING,
      };

      directionsService.route(request, function (result, status) {
        if (status === google.maps.DirectionsStatus.OK) {
          directionsRenderer.setDirections(result);
        } else {
          alert("No se pudo calcular la ruta: " + status);
        }
      });
    }
    </script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzCGzBz5OJc_GSnL3AkaWPVMEpxWHgRxY&callback=initMap">
    </script>

</body>
</html>