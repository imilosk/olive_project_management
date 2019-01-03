<?php 

require_once __DIR__ . '/../../models/PspPhase.php';

class PspPhaseController {

    public static function index() {
        $pspphases = PspPhase::get_all();
        Flight::json($pspphases);
    }

    public static function show($id) {
        $pspphase = PspPhase::get($id);
        Flight::json($pspphase);
    }

}