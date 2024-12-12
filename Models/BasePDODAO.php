<?php
namespace Models;

class BasePDODAO {
    private \PDO $db;

    private function getDB() : \PDO {
        if (isset($this->db))
            return $this->db;
        $this->db = new \PDO(\Config\Config::get('dsn'), \Config\Config::get('user'), \Config\Config::get('pass'));
        return $this->db;
    }

    protected function execRequest(string $sql, ?array $params = null) : \PDOStatement|false {
        $stmt = $this->getDB()->prepare($sql);
        
        if ($params != null) {
            foreach ($params as $key => $param) {
                $paramType = match (true) {
                    is_int($param) => \PDO::PARAM_INT,
                    is_bool($param) => \PDO::PARAM_BOOL,
                    is_null($param) => \PDO::PARAM_NULL,
                    default => \PDO::PARAM_STR
                };
                $stmt->bindValue(is_int($key) ? $key + 1 : ":" . $key, $param, $paramType);
            }
        }
        $stmt->execute();
        return $stmt;
    }
}