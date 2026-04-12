<?php
class Recette {
    private $conn;
    private $table_name = "recettes";

    public $id;
    public $title;
    public $description;
    public $instructions;
    public $duree;
    public $difficulte;
    public $saison;
    public $statut;
    public $score_durabilite;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function search($keyword) {
        $keyword = '%' . $keyword . '%';
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE title LIKE :keyword OR description LIKE :keyword
                  ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }

    public function readPublished() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE statut = 'Publié' ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function validate($data) {
        $errors = [];
        if(empty($data['title'])) $errors[] = "Le titre est requis";
        elseif(strlen($data['title']) < 3) $errors[] = "Le titre doit contenir au moins 3 caractères";
        if(isset($data['duree']) && !empty($data['duree'])) {
            if(!is_numeric($data['duree']) || $data['duree'] < 1) $errors[] = "La durée doit être un nombre positif";
        }
        return $errors;
    }

    public function create() {
        $errors = $this->validate($_POST);
        if(!empty($errors)) return ["success" => false, "errors" => $errors];

        $query = "INSERT INTO " . $this->table_name . "
                  SET title=:title, description=:description, instructions=:instructions,
                      duree=:duree, difficulte=:difficulte, saison=:saison,
                      statut=:statut, score_durabilite=:score_durabilite";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":instructions", $this->instructions);
        $stmt->bindParam(":duree", $this->duree);
        $stmt->bindParam(":difficulte", $this->difficulte);
        $stmt->bindParam(":saison", $this->saison);
        $stmt->bindParam(":statut", $this->statut);
        $stmt->bindParam(":score_durabilite", $this->score_durabilite);
        
        if($stmt->execute()) return ["success" => true];
        return ["success" => false, "errors" => ["Erreur lors de l'enregistrement"]];
    }

    public function update() {
        $errors = $this->validate($_POST);
        if(!empty($errors)) return ["success" => false, "errors" => $errors];

        $query = "UPDATE " . $this->table_name . "
                  SET title=:title, description=:description, instructions=:instructions,
                      duree=:duree, difficulte=:difficulte, saison=:saison,
                      statut=:statut, score_durabilite=:score_durabilite
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":instructions", $this->instructions);
        $stmt->bindParam(":duree", $this->duree);
        $stmt->bindParam(":difficulte", $this->difficulte);
        $stmt->bindParam(":saison", $this->saison);
        $stmt->bindParam(":statut", $this->statut);
        $stmt->bindParam(":score_durabilite", $this->score_durabilite);
        
        if($stmt->execute()) return ["success" => true];
        return ["success" => false, "errors" => ["Erreur lors de la mise à jour"]];
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }
}
?>