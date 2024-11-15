<?php

namespace Http;

class Request
{
    /**
     * Obtiene los datos del cuerpo de la solicitud en función del tipo de contenido.
     * 
     * @return array Los datos del cuerpo de la solicitud.
     */
    static public function getBodyArray(){
        $contentType = isset($_SERVER['CONTENT_TYPE']) ? explode(';', $_SERVER['CONTENT_TYPE'])[0] : '';
        $input = file_get_contents('php://input');

        if ($contentType === 'application/json') {

            $data = json_decode($input, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [];
            }
            return is_array($data) ? $data : [];

        } elseif ($contentType === 'application/x-www-form-urlencoded') {

            parse_str($input, $data);
            return is_array($data) ? $data : [];

        }  elseif ($contentType === 'multipart/form-data') {
            return $_POST;
        }

        return [];
    }

    /**
     * Obtiene los parámetros de consulta (query params) de la URL.
     * 
     * @return array Los parámetros de consulta.
     */
    static public function getParamArray(){
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING) ?: [];
    }

    /**
     * Obtiene el array de archivos de la solicitud `multipart/form-data`.
     * 
     * @return array El array de archivos.
     */
    static public function getFilesArray()
    {
        return !empty($_FILES) ? $_FILES : [];
    }
}
