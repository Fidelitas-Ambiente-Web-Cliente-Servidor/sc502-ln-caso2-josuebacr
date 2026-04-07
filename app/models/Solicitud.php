<?php
class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Verifica si el usuario ya tiene una solicitud activa o aprobada para ese taller
    public function existeSolicitudActiva($usuarioId, $tallerId)
    {
        $query = "SELECT id FROM solicitudes WHERE usuario_id = ? AND taller_id = ? AND estado IN ('pendiente', 'aprobada')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $usuarioId, $tallerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Crea una nueva solicitud de inscripción
    public function crear($usuarioId, $tallerId)
    {
        $query = "INSERT INTO solicitudes (taller_id, usuario_id, estado) VALUES (?, ?, 'pendiente')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $tallerId, $usuarioId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Retorna todas las solicitudes pendientes con info del taller y usuario
    public function getSolicitudesPendientes()
    {
        $query = "SELECT s.id, s.estado, s.fecha_solicitud,
                         t.nombre AS taller, t.cupo_disponible,
                         u.username AS usuario
                  FROM solicitudes s
                  JOIN talleres t ON s.taller_id = t.id
                  JOIN usuarios u ON s.usuario_id = u.id
                  WHERE s.estado = 'pendiente'
                  ORDER BY s.fecha_solicitud ASC";
        $result = $this->conn->query($query);
        $solicitudes = [];
        while ($row = $result->fetch_assoc()) {
            $solicitudes[] = $row;
        }
        return $solicitudes;
    }

    // Obtiene una solicitud por su ID
    public function getById($id)
    {
        $query = "SELECT * FROM solicitudes WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Aprueba la solicitud
    public function aprobar($id)
    {
        $query = "UPDATE solicitudes SET estado = 'aprobada' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Rechaza la solicitud
    public function rechazar($id)
    {
        $query = "UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
