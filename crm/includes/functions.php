<?php
function obtenerSocios($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM socios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener socios: " . $e->getMessage());
        return [];
    }
}
