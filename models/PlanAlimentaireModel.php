<?php
require_once 'Database.php';

class PlanAlimentaireModel {
    private $conn;
    private $table = "plan_alimentaires";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllPlans() {
        $query = "SELECT p.*, CONCAT(u.prenom, ' ', u.nom) AS user_name,
                         (SELECT COUNT(*) FROM plan_aliment pa WHERE pa.plan_id = p.id) AS aliments_count
                  FROM " . $this->table . " p
                  LEFT JOIN users u ON p.user_id = u.id
                  ORDER BY p.week DESC, p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlansByUser($userId) {
        $query = "SELECT p.*, CONCAT(u.prenom, ' ', u.nom) AS user_name,
                         (SELECT COUNT(*) FROM plan_aliment pa WHERE pa.plan_id = p.id) AS aliments_count
                  FROM " . $this->table . " p
                  LEFT JOIN users u ON p.user_id = u.id
                  WHERE p.user_id = :user_id
                  ORDER BY p.week DESC, p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlanById($id) {
        $query = "SELECT p.*, CONCAT(u.prenom, ' ', u.nom) AS user_name
                  FROM " . $this->table . " p
                  LEFT JOIN users u ON p.user_id = u.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlanAliments($planId) {
        $query = "SELECT a.*
                  FROM plan_aliment pa
                  INNER JOIN aliments a ON pa.aliment_id = a.id
                  WHERE pa.plan_id = :plan_id
                  ORDER BY a.nom ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':plan_id' => $planId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPlan($week, $userId, $alimentIds = []) {
        $query = "INSERT INTO " . $this->table . " (week, user_id) VALUES (:week, :user_id)";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute([
            ':week' => $week,
            ':user_id' => $userId
        ]);

        if(!$success) {
            return false;
        }

        $planId = $this->conn->lastInsertId();
        $this->syncPlanAliments($planId, $alimentIds);
        return true;
    }

    public function updatePlan($id, $week, $userId, $alimentIds = []) {
        $query = "UPDATE " . $this->table . " SET week = :week, user_id = :user_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute([
            ':id' => $id,
            ':week' => $week,
            ':user_id' => $userId
        ]);

        if($success) {
            $this->syncPlanAliments($id, $alimentIds);
        }

        return $success;
    }

    public function deletePlan($id) {
        $deletePivot = $this->conn->prepare("DELETE FROM plan_aliment WHERE plan_id = :id");
        $deletePivot->execute([':id' => $id]);

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function getAllUsers() {
        $query = "SELECT id, prenom, nom FROM users ORDER BY prenom ASC, nom ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAliments() {
        $query = "SELECT id, nom, categorie, calories FROM aliments ORDER BY nom ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSelectedAlimentIds($planId) {
        $query = "SELECT aliment_id FROM plan_aliment WHERE plan_id = :plan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':plan_id' => $planId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function syncPlanAliments($planId, $alimentIds) {
        $deleteQuery = "DELETE FROM plan_aliment WHERE plan_id = :plan_id";
        $deleteStmt = $this->conn->prepare($deleteQuery);
        $deleteStmt->execute([':plan_id' => $planId]);

        if(empty($alimentIds) || !is_array($alimentIds)) {
            return true;
        }

        $insertQuery = "INSERT INTO plan_aliment (plan_id, aliment_id) VALUES (:plan_id, :aliment_id)";
        $insertStmt = $this->conn->prepare($insertQuery);

        foreach($alimentIds as $alimentId) {
            $insertStmt->execute([
                ':plan_id' => $planId,
                ':aliment_id' => intval($alimentId)
            ]);
        }

        return true;
    }
}
?>
