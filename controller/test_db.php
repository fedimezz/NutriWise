<?php
require_once __DIR__ . '/../model/Database.php';

$database = new Database();
$db = $database->getConnection();

if($db) {
    echo "✅ Connexion à la base de données réussie !<br>";
    
    // Tester une requête
    $stmt = $db->query("SELECT COUNT(*) as total FROM aliments");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "📊 Nombre d'aliments : " . $result['total'] . "<br>";
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM recettes");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "📖 Nombre de recettes : " . $result['total'] . "<br>";
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "👤 Nombre d'utilisateurs : " . $result['total'] . "<br>";
} else {
    echo "❌ Erreur de connexion";
}
?>