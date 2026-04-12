<?php
class Aliment {
    private $conn;
    private $table_name = "aliments";

    public $id;
    public $nom;
    public $calories;
    public $proteins;
    public $glucides;
    public $lipids;
    public $eco_score;
    public $category_id;
    public $saison;
    public $durable;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT a.*, c.name as category_name 
                  FROM " . $this->table_name . " a
                  LEFT JOIN categories c ON a.category_id = c.id
                  ORDER BY a.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function search($keyword) {
        $keyword = '%' . $keyword . '%';
        $query = "SELECT a.*, c.name as category_name 
                  FROM " . $this->table_name . " a
                  LEFT JOIN categories c ON a.category_id = c.id
                  WHERE a.nom LIKE :keyword OR c.name LIKE :keyword
                  ORDER BY a.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT a.*, c.name as category_name 
                  FROM " . $this->table_name . " a
                  LEFT JOIN categories c ON a.category_id = c.id
                  WHERE a.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->nom = $row['nom'];
            $this->calories = $row['calories'];
            $this->proteins = $row['proteins'];
            $this->glucides = $row['glucides'];
            $this->lipids = $row['lipids'];
            $this->eco_score = $row['eco_score'];
            $this->category_id = $row['category_id'];
            $this->saison = $row['saison'];
            $this->durable = $row['durable'];
        }
        return $row;
    }

    public function validate($data) {
        $errors = [];
        if(empty($data['nom'])) $errors[] = "Le nom est requis";
        elseif(strlen($data['nom']) < 2) $errors[] = "Le nom doit contenir au moins 2 caractères";
        if(empty($data['calories'])) $errors[] = "Les calories sont requises";
        elseif(!is_numeric($data['calories']) || $data['calories'] < 0) $errors[] = "Les calories doivent être un nombre positif";
        return $errors;
    }

    public function create() {
        $errors = $this->validate($_POST);
        if(!empty($errors)) return ["success" => false, "errors" => $errors];

        $query = "INSERT INTO " . $this->table_name . "
                  SET nom=:nom, calories=:calories, proteins=:proteins, 
                      glucides=:glucides, lipids=:lipids, eco_score=:eco_score,
                      category_id=:category_id, saison=:saison, durable=:durable";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":calories", $this->calories);
        $stmt->bindParam(":proteins", $this->proteins);
        $stmt->bindParam(":glucides", $this->glucides);
        $stmt->bindParam(":lipids", $this->lipids);
        $stmt->bindParam(":eco_score", $this->eco_score);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":saison", $this->saison);
        $stmt->bindParam(":durable", $this->durable);
        
        if($stmt->execute()) return ["success" => true];
        return ["success" => false, "errors" => ["Erreur lors de l'enregistrement"]];
    }

    public function update() {
        $errors = $this->validate($_POST);
        if(!empty($errors)) return ["success" => false, "errors" => $errors];

        $query = "UPDATE " . $this->table_name . "
                  SET nom=:nom, calories=:calories, proteins=:proteins, 
                      glucides=:glucides, lipids=:lipids, eco_score=:eco_score,
                      category_id=:category_id, saison=:saison, durable=:durable
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":calories", $this->calories);
        $stmt->bindParam(":proteins", $this->proteins);
        $stmt->bindParam(":glucides", $this->glucides);
        $stmt->bindParam(":lipids", $this->lipids);
        $stmt->bindParam(":eco_score", $this->eco_score);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":saison", $this->saison);
        $stmt->bindParam(":durable", $this->durable);
        
        if($stmt->execute()) return ["success" => true];
        return ["success" => false, "errors" => ["Erreur lors de la mise à jour"]];
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function getCategories() {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>