<?php

namespace Core;

class View
{
    public static function render($view, $data = [])
    {
        // Extraer datos para que estén disponibles en la vista
        extract($data);

        // Construir la ruta de la vista
        $viewPath = __DIR__ . '/../' . $view;

        // Verificar si la vista existe
        if (file_exists($viewPath)) {
            // Incluir la vista
            include $viewPath;
        } else {
            // Manejo de error si la vista no existe
            throw new \Exception("La vista '{$view}' no existe.");
        }
    }
}
