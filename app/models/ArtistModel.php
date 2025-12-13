<?php
namespace app\models;

use \DataBase;
use \Model;

class ArtistModel extends Model {
    protected $table = "artistas";
    protected $primaryKey = "id";

    public $id;
    public $nombre;
    public $pais;
    public $baja;
    public $albumes = [];

    public static function all() {
        $sql = "SELECT id, nombre, pais, baja FROM artistas ORDER BY nombre ASC";
        $rows = DataBase::query($sql);

        $artistas = [];
        if ($rows) {
            foreach ($rows as $row) {
                $a = new self();
                foreach ($row as $k => $v) $a->$k = $v;
                $artistas[] = $a;
            }
        }
        return $artistas;
    }

    public static function find($id) {
        $sql = "SELECT id, nombre, pais, baja FROM artistas WHERE id = :id LIMIT 1";
        $row = DataBase::query($sql, [':id' => $id]);

        if (!$row) return false;

        $art = new self();
        foreach ($row[0] as $k => $v) $art->$k = $v;

        // cargar álbumes
        $sqlAlb = "
            SELECT id, titulo 
            FROM albumes 
            WHERE artista_id = :id
            ORDER BY titulo ASC
        ";
        $albRows = DataBase::query($sqlAlb, [':id' => $id]);

        $lista = [];
        if ($albRows) {
            foreach ($albRows as $r) {
                $o = new \stdClass();
                $o->id = $r->id;
                $o->titulo = $r->titulo;
                $lista[] = $o;
            }
        }

        $art->albumes = $lista;

        return $art;
    }
}
