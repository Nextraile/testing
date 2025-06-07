<?php

require_once __DIR__ . '/../models/DestinasiModel.php';

class DestinasiController {
    private $model;
    
    public function __construct() {
        global $db;
        require_once __DIR__ . '/../models/DestinasiModel.php';
        $this->model = new DestinasiModel($db);
    }
}

?>