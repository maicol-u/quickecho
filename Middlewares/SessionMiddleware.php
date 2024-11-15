<?php
use Http\Response;
function logMiddleware() {
    return function($params) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION)) {
            Response::error("Access denied", 403);
            exit;
        }
    };
}