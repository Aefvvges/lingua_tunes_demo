<?php
namespace app\models;

use \DataBase;
use \Model;

class MusicModel extends Model {
    protected $table = "canciones";
    protected $primaryKey = "id";

    public $id;
    public $cancion;
    public $youtube_id;    
    public $album;
    public $artista;

    /**
     * Trae todas las canciones con su álbum y artista
     */
    public static function all() {
        $sql = "
            SELECT 
                c.id, 
                c.titulo AS cancion, 
                a.id AS album_id,
                a.titulo AS album, 
                ar.id AS artista_id,
                ar.nombre AS artista, 
                c.youtube_id
            FROM canciones c
            JOIN albumes a ON c.album_id = a.id
            JOIN artistas ar ON a.artista_id = ar.id
            ORDER BY c.titulo ASC
        ";


        $result = DataBase::query($sql);

        $musicas = [];
        if ($result) {
            foreach ($result as $row) {
                $music = new self();
                foreach ($row as $key => $value) {
                    $music->$key = $value;
                }
                $musicas[] = $music;
            }
        }

        return $musicas;
    }

    /**
     * Trae una canción por su ID
     */
    public static function find($id) {
        $sql = "
            SELECT 
                c.id, 
                c.titulo AS cancion, 
                a.id AS album_id,
                a.titulo AS album, 
                ar.id AS artista_id,
                ar.nombre AS artista, 
                c.youtube_id
            FROM canciones c
            JOIN albumes a ON c.album_id = a.id
            JOIN artistas ar ON a.artista_id = ar.id
            WHERE c.id = :id
            LIMIT 1
        ";

        $result = DataBase::query($sql, [':id' => $id]);

        if ($result) {
            $music = new self();
            foreach ($result[0] as $key => $value) {
                $music->$key = $value;
            }
            return $music;
        }

        return false;
    }
}
