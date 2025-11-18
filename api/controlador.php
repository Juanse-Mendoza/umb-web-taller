<?php
// controlador.php
require_once "modelo.php";

class TareasController {
    private $model;

    public function __construct() {
        $this->model = new TareasModel();
    }

    public function manejarSolicitud() {
        $method = $_SERVER["REQUEST_METHOD"];

        switch ($method) {
            case "GET":
                $this->handleGet();
                break;

            case "POST":
                $this->handlePost();
                break;

            case "PUT":
                $this->handlePut();
                break;

            case "DELETE":
                $this->handleDelete();
                break;

            default:
                $this->response(["error" => "Método no permitido"], 405);
        }
    }

    // ------------------------------------------------------------
    // GET - Obtener tareas o tarea por ID
    // ------------------------------------------------------------
    private function handleGet() {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $data = $this->model->obtenerTareaPorId($id);
        } else {
            $data = $this->model->obtenerTareas();
        }

        $this->response($data);
    }

    // ------------------------------------------------------------
    // POST - Crear tarea
    // ------------------------------------------------------------
    private function handlePost() {
        // Puede venir por form-data o raw JSON
        $titulo = $_POST["titulo"] ?? null;
        $completada = isset($_POST["completada"]) ? ($_POST["completada"] == "true") : false;

        // Si no viene por POST, intentamos JSON raw
        if (!$titulo) {
            $json = json_decode(file_get_contents("php://input"), true);
            $titulo = $json["titulo"] ?? null;
            $completada = $json["completada"] ?? false;
        }

        if (!$titulo) {
            $this->response(["error" => "El campo 'titulo' es obligatorio"], 400);
            return;
        }

        $result = $this->model->crearTarea($titulo, $completada);
        $this->response($result, 201);
    }

    // ------------------------------------------------------------
    // PUT - Actualizar tarea
    // ------------------------------------------------------------
    private function handlePut() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["id"])) {
            $this->response(["error" => "ID requerido para actualizar"], 400);
            return;
        }

        $id = $data["id"];
        $titulo = $data["titulo"] ?? null;
        $completada = $data["completada"] ?? null;

        if ($titulo === null || $completada === null) {
            $this->response(["error" => "Faltan campos: titulo y completada"], 400);
            return;
        }

        $result = $this->model->actualizarTarea($id, $titulo, $completada);
        $this->response($result);
    }

    // ------------------------------------------------------------
    // DELETE - Eliminar tarea
    // ------------------------------------------------------------
    private function handleDelete() {
        if (!isset($_GET["id"])) {
            $this->response(["error" => "ID requerido para eliminar"], 400);
            return;
        }

        $id = $_GET["id"];
        $result = $this->model->eliminarTarea($id);
        $this->response($result);
    }

    // ------------------------------------------------------------
    // Respuesta estandarizada JSON
    // ------------------------------------------------------------
    private function response($data, $status = 200) {
        http_response_code($status);
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}
