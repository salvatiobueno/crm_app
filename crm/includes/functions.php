

function obtenerSocios($pdo) {
    $stmt = $pdo->query("SELECT * FROM socios ORDER BY nombre ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
