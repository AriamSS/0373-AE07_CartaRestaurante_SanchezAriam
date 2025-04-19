<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Menú Cubano - Sabor Tradicional</title>
</head>
<body class="bg-primary text-light">

<?php
if (file_exists('./xml/carta.xml')) {
    $menu = simplexml_load_file('./xml/carta.xml');
} else {
    exit('Error al abrir el archivo de datos.');
}
$tipoSeleccionado = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand text-primary" href="#"><strong>Menú Cubano - Sabor Tradicional</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <?php
                $tipos = [];
                foreach ($menu->plato as $plato) {
                    $tipo = (string)$plato['tipo'];
                    if (!in_array($tipo, $tipos)) {
                        echo '<li class="nav-item">';
                        if ($tipoSeleccionado === $tipo) {
                            echo '<a class="nav-link active text-danger" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
                        } else {
                            echo '<a class="nav-link text-primary" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
                        }
                        echo '</li>';

                        $tipos[] = $tipo;
                    }
                }
                ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="text-center mb-4 text-danger">Menú Cubano</h1>
    <?php if ($tipoSeleccionado !== ''): ?>
        <p class="text-center text-light">Aqui tienes nuestros <strong><?php echo ucfirst($tipoSeleccionado); ?></strong></p>
    <?php else: ?>
        <p class="text-center text-light">Todos los platos disponibles en nuestra carta.</p>
    <?php endif; ?>
    <div class="row">

    <?php
    foreach ($menu->plato as $plato) {
        if ($tipoSeleccionado === '' || $tipoSeleccionado === (string)$plato['tipo']) {
            echo '<div class="col-lg-4 col-md-6 mb-4">';
            echo '<div class="menu-item card bg-light text-dark">';
            if (!empty($plato->imagen)) {
                echo '<img src="' . $plato->imagen . '" class="card-img-top menu-img" alt="' . $plato->nombre . '">';
            } else {
                echo '<img src="img/default.jpg" class="card-img-top menu-img" alt="Imagen no disponible">';
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-danger">' . $plato->nombre . '</h5>';
            echo '<p class="card-text">' . $plato->descripcion . '</p>';
            echo '<p><strong>Precio:</strong> ' . $plato->precio . '€</p>';
            echo '<p><strong>Calorías:</strong> ' . $plato->calorias . ' kcal</p>';
            echo '<p><strong>Ingredientes:</strong> ';
            foreach ($plato->ingredientes->categoria as $ingrediente) {
                $icon = '';
                switch (strtolower($ingrediente)) {
                    case 'vegano':
                        $icon = '<i class="fas fa-leaf"></i>';
                        break;
                    case 'sin gluten':
                        $icon = '<i class="fas fa-check-circle"></i>';
                        break;
                    case 'carne':
                        $icon = '<i class="fas fa-drumstick-bite"></i>';
                        break;
                    case 'ave':
                        $icon = '<i class="fas fa-dove"></i>';
                        break;
                    case 'lácteo':
                        $icon = '<i class="fas fa-cheese"></i>';
                        break;
                    case 'legumbres':
                        $icon = '<i class="fas fa-seedling"></i>';
                        break;
                    case 'maíz':
                        $icon = '<i class="fas fa-corn"></i>';
                        break;
                    case 'huevo':
                        $icon = '<i class="fas fa-egg"></i>';
                        break;
                    case 'fruta':
                        $icon = '<i class="fas fa-apple-alt"></i>';
                        break;
                    default:
                        $icon = '<i class="fas fa-utensils"></i>';
                        break;
                }
                echo $icon . ' ' . $ingrediente . '<br>';
            }
            echo '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>