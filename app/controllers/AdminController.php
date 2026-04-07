<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    public function getSolicitudesJson()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode([]);
            return;
        }
        $solicitudes = $this->solicitudModel->getSolicitudesPendientes();
        echo json_encode($solicitudes);
    }

    // Aprobar solicitud
    public function aprobar()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        $solicitudId = intval($_POST['id_solicitud'] ?? 0);

        try {
            // Obtener la solicitud
            $solicitud = $this->solicitudModel->getById($solicitudId);
            if (!$solicitud) {
                echo json_encode(['success' => false, 'message' => 'Solicitud no encontrada']);
                return;
            }

            // Verificar cupo disponible en tiempo real
            $taller = $this->tallerModel->getById($solicitud['taller_id']);
            if (!$taller || $taller['cupo_disponible'] <= 0) {
                echo json_encode(['success' => false, 'message' => 'El taller ya no tiene cupos disponibles']);
                return;
            }

            // Descontar cupo y aprobar solicitud
            $desconto = $this->tallerModel->descontarCupo($solicitud['taller_id']);
            if (!$desconto) {
                echo json_encode(['success' => false, 'message' => 'No se pudo descontar el cupo']);
                return;
            }

            $this->solicitudModel->aprobar($solicitudId);
            echo json_encode(['success' => true, 'message' => 'Solicitud aprobada exitosamente']);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Rechazar solicitud
    public function rechazar()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        $solicitudId = intval($_POST['id_solicitud'] ?? 0);

        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true, 'message' => 'Solicitud rechazada']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al rechazar']);
        }
    }
}
