<?php
/**
 * Standardized database operations to ensure proper connection handling
 */

function executeQuery($query, $params = []) {
    $db = dbnew::getInstance();
    try {
        if (!empty($params)) {
            $stmt = $db->connection->prepare($query);
            $stmt->execute($params);
        } else {
            $stmt = $db->connection->query($query);
        }
        return $stmt;
    } catch (PDOException $e) {
        error_log("Query execution error: " . $e->getMessage());
        throw $e;
    }
}

function fetchOne($query, $params = []) {
    $stmt = executeQuery($query, $params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}

function fetchAll($query, $params = []) {
    $stmt = executeQuery($query, $params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $result;
}

function getRowCount($query, $params = []) {
    $stmt = executeQuery($query, $params);
    $count = $stmt->rowCount();
    $stmt->closeCursor();
    return $count;
} 