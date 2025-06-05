<?php

require_once __DIR__ . '/../models/DestinasiModel.php';

class DestinasiController {
    private $model;
    
    public function __construct() {
        global $db;
        require_once __DIR__ . '/../models/DestinasiModel.php';
        $this->model = new DestinasiModel($db);
    }
//ngawur
    public function tableListDestinasi() {
        $destinasi = $this->model->getDestinasiTableAdmin();
        require_once __DIR__ . '/../views/admin/admin-panel.php';
    }
}

?>