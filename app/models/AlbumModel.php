<?php
namespace app\models;

use \DataBase;
use \Model;

class AlbumModel extends Model {
    protected $table = "albumes";
    protected $primaryKey = "id";

    public $id;
    public $titulo;
    public $anio;
    public $artista_id;
    public $baja;
    public $canciones = [];

    /** Traer todos los álbumes */
    public static function all() {
        $sql = "
            SELECT 
                al.id, 
                al.titulo, 
                al.anio, 
                al.artista_id,
                ar.nombre AS artista
            FROM albumes al
            JOIN artistas ar ON al.artista_id = ar.id
            ORDER BY al.titulo ASC
        ";

        $rows = DataBase::query($sql);

        $albumes = [];
        if ($rows) {
            foreach ($rows as $row) {
                $alb = new self();
                foreach ($row as $k => $v) $alb->$k = $v;
                $albumes[] = $alb;
            }
        }
        return $albumes;
    }

    public static function find($id)
    {
        // Traer datos del álbum
        $sql = "
            SELECT 
                al.id,
                al.titulo,
                al.artista_id,
                ar.nombre AS artista_nombre
            FROM albumes al
            JOIN artistas ar ON ar.id = al.artista_id
            WHERE al.id = ?
            LIMIT 1
        ";

        $result = DataBase::query($sql, [$id]);
        if (!$result) return null;

        $album = $result[0];

        // Traer canciones del álbum
        $sqlCanciones = "
            SELECT id, titulo
            FROM canciones
            WHERE album_id = ?
        ";

        $album->canciones = DataBase::query($sqlCanciones, [$album->id]);

        return $album;
    }

}
