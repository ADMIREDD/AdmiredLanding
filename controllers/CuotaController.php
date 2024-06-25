<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CuotaModel;

class CuotaController extends ResourceController
{
    public function create()
    {
        // Define reglas de validación para los campos
        $rules = [
            'FECHA' => 'required|valid_date',
            'ESTADO' => 'required|string|max_length[50]',
            'FECHA_LIMITE' => 'required|valid_date',
            'PRECIO' => 'required|decimal'
        ];

        // Obtén los datos del cuerpo de la solicitud
        $data = $this->request->getPost();

        // Valida los datos
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Intenta insertar los datos en la base de datos
        try {
            $cuotaModel = new CuotaModel();
            $cuotaId = $cuotaModel->insert($data);

            if (!$cuotaId) {
                return $this->failServerError('Failed to create cuota');
            }

            // Devuelve respuesta de éxito
            return $this->respondCreated(['ID' => $cuotaId, 'message' => 'Cuota creada exitosamente']);
        } catch (\Exception $e) {
            // Captura cualquier excepción no esperada
            log_message('error', $e->getMessage());
            return $this->failServerError('An unexpected error occurred');
        }
    }
}
