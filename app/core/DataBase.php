<?php
namespace app\core;

use PDO;
use PDOException;

class DataBase
{
    private static $host = "localhost";
    private static $dbname = "lingua_tunes_demo";
    private static $dbuser = "root";
    private static $dbpass = "";

    private static $dbh = null; // Handler de la base
    private static $error;

    // Conectar a la base (singleton)
    private static function connection()
    {
        if (self::$dbh === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            try {
                self::$dbh = new PDO($dsn, self::$dbuser, self::$dbpass, $options);
                self::$dbh->exec('SET time_zone = "-03:00";');
            } catch (PDOException $e) {
                self::$error = $e->getMessage();
                throw new \Exception("❌ Error de conexión a la base de datos: " . self::$error);
            }
        }
        return self::$dbh;
    }

    // Consultas SELECT → devuelve objetos
    public static function query($sql, $params = [])
    {
        $stmt = self::prepareAndExecute($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // INSERT, UPDATE, DELETE → devuelve filas afectadas
    public static function execute($sql, $params = [])
    {
        return self::prepareAndExecute($sql, $params)->rowCount();
    }

    // Devuelve el último ID insertado
    public static function lastInsertId()
    {
        return self::connection()->lastInsertId();
    }

    // Ejecuta múltiples operaciones en transacción
    public static function transaction($queries)
    {
        $dbh = self::connection();
        try {
            $dbh->beginTransaction();
            foreach ($queries as $query) {
                $stmt = $dbh->prepare($query['sql']);
                $stmt->execute($query['params'] ?? []);
            }
            $dbh->commit();
            return true;
        } catch (PDOException $e) {
            $dbh->rollBack();
            throw new \Exception("❌ Error en transacción: " . $e->getMessage());
        }
    }

    // Método interno: preparar + ejecutar
    private static function prepareAndExecute($sql, $params = [])
    {
        $stmt = self::connection()->prepare($sql);
        try {
            $stmt->execute($params);
        } catch (PDOException $e) {
            throw new \Exception("❌ Error en la consulta SQL: " . $e->getMessage() . "<br>Consulta: $sql");
        }
        return $stmt;
    }
}
