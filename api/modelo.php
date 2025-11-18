<?php
require_once "db.php";

class TareasModel {
    private $db;

    public function __construct() {
        $this->db = new SupabaseDB();
    }

    // 1. Obtener todas las tareas

    public function obtenerTareas() {
        return $this->db->request("tareas?select=*");
    }

    // 2. Obtener una tarea por ID

    public function obtenerTareaPorId($id) {
        return $this->db->request("tareas?id=eq.$id&select=*");
    }

    // 3. Crear una nueva tarea

    public function crearTarea($titulo, $completada = false) {
        $data = [
            "titulo" => $titulo,
            "completada" => $completada
        ];

        return $this->db->request("tareas", "POST", $data);
    }

    // 4. Actualizar una tarea

    public function actualizarTarea($id, $titulo, $completada) {
        $data = [
            "titulo" => $titulo,
            "completada" => $completada
        ];

        return $this->db->request("tareas?id=eq.$id", "PATCH", $data);
    }

    // 5. Eliminar una tarea

    public function eliminarTarea($id) {
        return $this->db->request("tareas?id=eq.$id", "DELETE");
    }
}
