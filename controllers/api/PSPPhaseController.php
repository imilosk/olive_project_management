<?php 

require_once __DIR__ . '/../../models/PSPPhase.php';

class PSPPhaseController {

    public static function index() {
        $pspphases = PspPhase::get_all();
        Flight::json($pspphases);
    }

    public static function show($id) {
        $pspphase = PspPhase::get($id);
        Flight::json($pspphase);
    }

}
