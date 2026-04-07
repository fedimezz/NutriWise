<?php
// models/AlimentModel.php
require_once 'Database.php';

class AlimentModel {
    private $conn;
    private $table = "aliments";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Récupérer tous les aliments
    public function getAllAliments() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nom ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter le nombre d'aliments
    public function countAliments() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Ajouter un aliment
public function addAliment($nom, $category_id, $calories, $proteines, $glucides, $lipides, $eco_score) {
    $query = "INSERT INTO " . $this->table . " (nom, category_id, calories, proteines, glucides, lipides, eco_score) 
              VALUES (:nom, :cat_id, :cal, :prot, :glu, :lip, :eco)";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([
        ':nom' => $nom,
        ':cat_id' => $category_id,
        ':cal' => $calories,
        ':prot' => $proteines,
        ':glu' => $glucides,
        ':lip' => $lipides,
        ':eco' => $eco_score
    ]);
}

    // Supprimer un aliment
    public function deleteAliment($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    // Modifier un aliment
    public function updateAliment($id, $nom, $categorie, $calories, $proteines, $glucides, $lipides, $durable) {
        $query = "UPDATE " . $this->table . "
                  SET nom = :nom, categorie = :categorie, calories = :calories, 
                      proteines = :proteines, glucides = :glucides, lipides = :lipides, durable = :durable
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':categorie' => $categorie,
            ':calories' => $calories,
            ':proteines' => $proteines,
            ':glucides' => $glucides,
            ':lipides' => $lipides,
            ':durable' => $durable
        ]);
    }

    // Récupérer un aliment par ID
    public function getAlimentById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>