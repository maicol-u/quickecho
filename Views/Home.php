<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://via.placeholder.com/1920x1080') no-repeat center center;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-content {
            background: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 8px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="display-4">¡Bienvenido a Nuestro Sitio Web!</h1>
                <p class="lead">Estamos encantados de tenerte aquí. Explora nuestras ofertas y descubre lo que tenemos para ti.</p>
                <a href="#more-info" class="btn btn-custom btn-lg">Descubre Más</a>
            </div>
        </section>
    </header>

    <!-- More Info Section -->
    <section id="more-info" class="container my-5">
        <h2 class="text-center">¿Qué Ofrecemos?</h2>
        <p class="text-center">Aquí puedes encontrar más detalles sobre nuestros servicios y productos. No dudes en ponerte en contacto con nosotros para cualquier consulta.</p>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
