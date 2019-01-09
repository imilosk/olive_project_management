<?php 

require_once __DIR__ . '/../../models/UserPSPData.php';

class UserPSPDataController {

    public static function store() {
        $idUser = $_POST["idUser"];
        $size = $_POST["size"];
        $planning_time = $_POST["planning_time"];
        $infrastructuring_time = $_POST["infrastructuring_time"];
        $coding_time = $_POST["coding_time"];
        $code_review_time = $_POST["code_review_time"];
        $compiling_time = $_POST["compiling_time"];
        $testing_time = $_POST["testing_time"];
        $analysis_time = $_POST["analysis_time"];
        $planning_in_err = $_POST["planning_in_err"];
        $infrastructuring_in_err = $_POST["infrastructuring_in_err"];
        $coding_in_err = $_POST["coding_in_err"];
        $code_review_in_err = $_POST["code_review_in_err"];
        $compiling_in_err = $_POST["compiling_in_err"];
        $testing_in_err = $_POST["testing_in_err"];
        $analysis_in_err = $_POST["analysis_in_err"];
        $planning_res_err = $_POST["planning_res_err"];
        $infrastructuring_res_err = $_POST["infrastructuring_res_err"];
        $coding_res_err = $_POST["coding_res_err"];
        $code_review_res_err = $_POST["code_review_res_err"];
        $compiling_res_err = $_POST["compiling_res_err"];
        $testing_res_err = $_POST["testing_res_err"];
        $analysis_res_err = $_POST["analysis_res_err"];
        $psp_number = $_POST["psp_number"];
        $response = UserPSPData::insert($idUser, $size, $planning_time, $infrastructuring_time, $coding_time, $code_review_time, $compiling_time, $testing_time, $analysis_time, $planning_in_err, $infrastructuring_in_err, $coding_in_err, $code_review_in_err, $compiling_in_err, $testing_in_err, $analysis_in_err, $planning_res_err, $infrastructuring_res_err, $coding_res_err, $code_review_res_err, $compiling_res_err, $testing_res_err, $analysis_res_err, $psp_number);
        Flight::json($response);
    }

    public static function delete($idUser) {
        $response = UserPSPData::delete($idUser);
        Flight::json($response);
    }

    public static function get_user_psps($idUser) {
        $user_psps = UserPSPData::get_user_psps($idUser);
        Flight::json($user_psps);
    }

}