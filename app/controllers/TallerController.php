<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }

    public function getTalleresJson()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            return;
        }

        $talleres = $this->tallerModel->getAllDisponibles();
        echo json_encode($talleres);
    }

    public function solicitar()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            return;
        }

        $tallerId  = intval($_POST['taller_id'] ?? 0);
        $usuarioId = $_SESSION['id'];

        // Validar que el taller exista y tenga cupo
        $taller = $this->tallerModel->getById($tallerId);
        if (!$taller) {
            echo json_encode(['success' => false, 'message' => 'Taller no encontrado']);
            return;
        }

        if ($taller['cupo_disponible'] <= 0) {
            echo json_encode(['success' => false, 'message' => 'El taller no tiene cupos disponibles']);
            return;
        }

        // Validar que no tenga solicitud activa o aprobada para el mismo taller
        if ($this->solicitudModel->existeSolicitudActiva($usuarioId, $tallerId)) {
            echo json_encode(['success' => false, 'message' => 'Ya tienes una solicitud activa o aprobada para este taller']);
            return;
        }

        // Crear la solicitud
        if ($this->solicitudModel->crear($usuarioId, $tallerId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud enviada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear la solicitud']);
        }
    }
}
