<?php

define('APP_NAME', 'ClinicDesk');
define('BASE_URL', 'http://localhost/clinicdesk/'); // عدله حسب مسار السيرفر عندك
define('ITEMS_PER_PAGE', 10);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}