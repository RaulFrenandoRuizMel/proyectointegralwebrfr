<?php
include 'conexion_1.php';

// Cargar usuarios de la base de datos
try {
    $stmt = $conn->prepare("SELECT id_grupo, grupo_grp FROM grupo ORDER BY id_grupo");
    $stmt->execute();
    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar usuarios: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Personal</title>
        <link rel="stylesheet" href="css/styles.css">

</head>
<body>

    <form action="guardar_alumno.php" method="post" class="contenedor_formulario">
            <h2>Registrar Maestra</h2>

        <label>Seleccionar Grupo:</label><br>
        <select name="id_grupo" required>
            <option value="">-- Selecciona un Grupo --</option>
            <?php foreach ($grupos as $grupo): ?>
                <option value="<?php echo htmlspecialchars($grupo['id_grupo']); ?>">
                    ID: <?php echo htmlspecialchars($grupo['id_grupo']); ?> - 
                    <?php echo htmlspecialchars($grupo['grupo_grp']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre_alu" required><br><br>

        <label>Apellidos:</label><br>
        <input type="text" name="apellidos_alu" required><br><br>

        <button type="submit">guardar</button>
        <button onclick="window.location.href='index.php'">regresar a inicio</button>

    </form>
    
</body>
</html>