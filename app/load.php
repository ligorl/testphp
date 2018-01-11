<?php
session_start();
require_once 'core/db.php';
require_once 'core/routing.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
//Запуск роутинга

Routing::execute($config);