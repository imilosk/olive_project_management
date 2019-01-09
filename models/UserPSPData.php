<?php
require_once __DIR__ . '/../settings/DBInit.php';

class UserPSPData {
    const TABLE_NAME = 'user_psp_data';

    public static function insert($idUser, $size, $planning_time, $infrastructuring_time, $coding_time, $code_review_time, $compiling_time, $testing_time, $analysis_time, $planning_in_err, $infrastructuring_in_err, $coding_in_err, $code_review_in_err, $compiling_in_err, $testing_in_err, $analysis_in_err, $planning_res_err, $infrastructuring_res_err, $coding_res_err, $code_review_res_err, $compiling_res_err, $testing_res_err, $analysis_res_err, $psp_number) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (idUser, size, planning_time, infrastructuring_time, coding_time, code_review_time, compiling_time, testing_time, analysis_time, planning_in_err, infrastructuring_in_err, coding_in_err, code_review_in_err, compiling_in_err, testing_in_err, analysis_in_err, planning_res_err, infrastructuring_res_err, coding_res_err, code_review_res_err, compiling_res_err, testing_res_err, analysis_res_err, psp_number)
                                   VALUES (:idUser, :size, :planning_time, :infrastructuring_time, :coding_time, :code_review_time, :compiling_time, :testing_time, :analysis_time, :planning_in_err, :infrastructuring_in_err, :coding_in_err, :code_review_in_err, :compiling_in_err, :testing_in_err, :analysis_in_err, :planning_res_err, :infrastructuring_res_err, :coding_res_err, :code_review_res_err, :compiling_res_err, :testing_res_err, :analysis_res_err, :psp_number)");
        $statement->bindParam(":idUser", $idUser);
        $statement->bindParam(":size", $size);
        $statement->bindParam(":planning_time", $planning_time);
        $statement->bindParam(":infrastructuring_time", $infrastructuring_time);
        $statement->bindParam(":coding_time", $coding_time);
        $statement->bindParam(":code_review_time", $code_review_time);
        $statement->bindParam(":compiling_time", $compiling_time);
        $statement->bindParam(":testing_time", $testing_time);
        $statement->bindParam(":analysis_time", $analysis_time);
        $statement->bindParam(":planning_in_err", $planning_in_err);
        $statement->bindParam(":infrastructuring_in_err", $infrastructuring_in_err);
        $statement->bindParam(":coding_in_err", $coding_in_err);
        $statement->bindParam(":code_review_in_err", $code_review_in_err);
        $statement->bindParam(":compiling_in_err", $compiling_in_err);
        $statement->bindParam(":testing_in_err", $testing_in_err);
        $statement->bindParam(":analysis_in_err", $analysis_in_err);
        $statement->bindParam(":planning_res_err", $planning_res_err);
        $statement->bindParam(":infrastructuring_res_err", $infrastructuring_res_err);
        $statement->bindParam(":coding_res_err", $coding_res_err);
        $statement->bindParam(":code_review_res_err", $code_review_res_err);
        $statement->bindParam(":compiling_res_err", $compiling_res_err);
        $statement->bindParam(":testing_res_err", $testing_res_err);
        $statement->bindParam(":analysis_res_err", $analysis_res_err);
        $statement->bindParam(":psp_number", $psp_number);
        $statement->execute();
        //return "true";
    }

    public static function delete_all($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table}
                                   WHERE idUser = :idUser");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return "true";
    } 

    public static function delete_one($idUser, $psp_number) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table}
                                   WHERE idUser = :idUser
                                   AND psp_number = :psp_number");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":psp_number", $psp_number, PDO::PARAM_INT);
        $statement->execute();
        return "true";
    } 

    public static function get_user_psps($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT *
                                    FROM {$table}
                                    WHERE idUser = :idUser");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}