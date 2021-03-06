<?php 

require_once __DIR__ . '/../../models/PSPErrorCategories.php';

class PSPErrorCategoryController {

    public static function index() {
        $psperrorcategories = PspErrorCategorie::get_all();
        Flight::json($psperrorcategories);
    }

    public static function show($id) {
        $psperrorcategorie = PspErrorCategorie::get($id);
        Flight::json($psperrorcategorie);
    }

}
