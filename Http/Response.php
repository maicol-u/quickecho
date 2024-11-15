<?php

namespace Http;

class Response {

    /**
     * Envía una respuesta JSON al cliente.
     *
     * Este método establece el código de estado HTTP y el tipo de contenido
     * antes de enviar una respuesta JSON al cliente.
     *
     * @param mixed $data Los datos que se enviarán en la respuesta JSON.
     * @param int $status (opcional) El código de estado HTTP que se establecerá. Por defecto es 200 (OK).
     * 
     * @return void
     */
    static public function jsonResponse($data, $status = 200){
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Envía una respuesta de error.
     *
     * @param string $message El mensaje de error a enviar.
     * @param int $status (opcional) El código de estado HTTP. Por defecto es 400.
     * @return void
     */
    static public function error($message, $status = 400){
        self::jsonResponse(['success' => false, 'message' => $message], $status);
    }

    /**
     * Envía una respuesta de éxito.
     *
     * @param mixed $data Los datos a enviar en la respuesta.
     * @param int $status (opcional) El código de estado HTTP. Por defecto es 200.
     * @return void
     */
    static public function success($data, $status = 200){
        self::jsonResponse(['success' => true, 'data' => $data], $status);
    }

    /**
     * Redirige a una URL especificada.
     *
     * @param string $url La URL a la que se redirigirá al cliente.
     * @param int $status (opcional) El código de estado HTTP para la redirección. Por defecto es 302.
     * @return void
     */
    static public function redirect($url, $status = 302) {
        http_response_code($status);
        header("Location: $url");
        exit();
    }
}
