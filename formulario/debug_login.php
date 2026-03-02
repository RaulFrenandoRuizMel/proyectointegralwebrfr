<?php
include 'conexion_1.php';

// Coloca aquí el ID del usuario con el que estás intentando hacer login
$id_usuario_prueba = 27; // Cambia esto al ID que estés usando

// Coloca la contraseña que estás intentando usar
$password_prueba = "1234"; // Cambia esto a la contraseña que estás usando

echo "<h2>🔍 Debug de Login</h2>";

try {
    $stmt = $conn->prepare("SELECT id_usu, usuario_usu, password_usu, rol FROM usuarios WHERE id_usu = ?");
    $stmt->execute([$id_usuario_prueba]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<div style='background: #e7f3ff; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3;'>";
        echo "<h3>📋 Datos del usuario en BD:</h3>";
        echo "ID: <strong>{$user['id_usu']}</strong><br>";
        echo "Usuario: <strong>{$user['usuario_usu']}</strong><br>";
        echo "Rol: <strong>{$user['rol']}</strong><br>";
        echo "Password en BD: <code>{$user['password_usu']}</code><br>";
        echo "Longitud del password: <strong>" . strlen($user['password_usu']) . "</strong> caracteres<br>";
        echo "</div>";
        
        // Verificar si está encriptada
        echo "<div style='background: #fff3cd; padding: 15px; margin: 10px 0; border-left: 4px solid #ffc107;'>";
        echo "<h3>🔐 Análisis de encriptación:</h3>";
        
        if (strlen($user['password_usu']) == 60 && strpos($user['password_usu'], '$2y$') === 0) {
            echo "✅ La contraseña <strong>SÍ está encriptada correctamente</strong><br>";
            echo "Formato: password_hash() con bcrypt<br>";
        } else {
            echo "❌ La contraseña <strong>NO está encriptada</strong> o tiene formato incorrecto<br>";
            echo "Parece ser texto plano: <strong style='color: red;'>{$user['password_usu']}</strong><br>";
        }
        echo "</div>";
        
        // Probar password_verify
        echo "<div style='background: #f8d7da; padding: 15px; margin: 10px 0; border-left: 4px solid #dc3545;'>";
        echo "<h3>🧪 Prueba de verificación:</h3>";
        echo "Contraseña que estás probando: <strong style='color: blue;'>{$password_prueba}</strong><br><br>";
        
        if (password_verify($password_prueba, $user['password_usu'])) {
            echo "✅ <strong style='color: green; font-size: 18px;'>¡PASSWORD_VERIFY FUNCIONÓ!</strong><br>";
            echo "La contraseña '<strong>{$password_prueba}</strong>' es correcta para este usuario.<br>";
            echo "El login debería funcionar.";
        } else {
            echo "❌ <strong style='color: red; font-size: 18px;'>PASSWORD_VERIFY FALLÓ</strong><br>";
            echo "La contraseña '<strong>{$password_prueba}</strong>' NO coincide con la guardada en BD.<br><br>";
            
            echo "<strong>Posibles causas:</strong><br>";
            echo "1. La contraseña que estás usando es incorrecta<br>";
            echo "2. La contraseña en BD no está encriptada con password_hash()<br>";
            echo "3. La contraseña fue encriptada con otro método<br>";
        }
        echo "</div>";
        
        // Generar hash de la contraseña de prueba
        echo "<div style='background: #d4edda; padding: 15px; margin: 10px 0; border-left: 4px solid #28a745;'>";
        echo "<h3>🔧 Solución:</h3>";
        $nuevo_hash = password_hash($password_prueba, PASSWORD_DEFAULT);
        echo "Si quieres que la contraseña '<strong>{$password_prueba}</strong>' funcione para este usuario,<br>";
        echo "ejecuta esta consulta SQL en phpMyAdmin:<br><br>";
        echo "<textarea style='width: 100%; height: 80px; font-family: monospace; padding: 10px;'>";
        echo "UPDATE usuarios SET password_usu = '{$nuevo_hash}' WHERE id_usu = {$id_usuario_prueba};";
        echo "</textarea>";
        echo "</div>";
        
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid #dc3545;'>";
        echo "❌ No se encontró un usuario con ID: <strong>{$id_usuario_prueba}</strong>";
        echo "</div>";
    }
    
    // Mostrar todos los usuarios
    echo "<hr>";
    echo "<h3>👥 Todos los usuarios en la base de datos:</h3>";
    $stmt_all = $conn->prepare("SELECT id_usu, usuario_usu, password_usu, rol FROM usuarios");
    $stmt_all->execute();
    $todos = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'>";
    echo "<th>ID</th><th>Usuario</th><th>Password (primeros 30 chars)</th><th>Longitud</th><th>Rol</th><th>Estado</th>";
    echo "</tr>";
    
    foreach ($todos as $u) {
        $encriptada = (strlen($u['password_usu']) == 60 && strpos($u['password_usu'], '$2y$') === 0);
        $color = $encriptada ? '#d4edda' : '#f8d7da';
        
        echo "<tr style='background: $color;'>";
        echo "<td>{$u['id_usu']}</td>";
        echo "<td><strong>{$u['usuario_usu']}</strong></td>";
        echo "<td><code>" . substr($u['password_usu'], 0, 30) . "...</code></td>";
        echo "<td>" . strlen($u['password_usu']) . "</td>";
        echo "<td>{$u['rol']}</td>";
        echo "<td>" . ($encriptada ? "✅ Encriptada" : "❌ Texto plano") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>