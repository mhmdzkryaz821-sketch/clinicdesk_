<?php


if (!function_exists('sanitize')) {
    function sanitize($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date) {
        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('formatTime')) {
    function formatTime($time) {
        return date('h:i A', strtotime($time));
    }
}

if (!function_exists('redirect')) {
    function redirect($path) {
        header("Location: " . BASE_URL . $path);
        exit();
    }
}