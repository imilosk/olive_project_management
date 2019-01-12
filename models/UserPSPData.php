<?php
require_once __DIR__ . '/../settings/DBInit.php';

class UserPSPData {
    const TABLE_NAME = 'user_psp_data';



    public static function create($idUser) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO {$table} (idUser)
                                   VALUES (:idUser)");
        $statement->bindParam(":idUser", $idUser);
        $statement->execute();
        //return "true";
    }


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

    public static function update($arr) {
        extract($arr);
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("UPDATE {$table} 
        SET size=:size,
            planning_time=:planning_time,
            infrastructuring_time=:infrastructuring_time,
            coding_time=:coding_time,
            code_review_time=:code_review_time,
            compiling_time=:compiling_time,
            testing_time=:testing_time,
            analysis_time=:analysis_time,
            planning_in_err=:planning_in_err,
            infrastructuring_in_err=:infrastructuring_in_err,
            coding_in_err=:coding_in_err,
            code_review_in_err=:code_review_in_err,
            compiling_in_err=:compiling_in_err,
            testing_in_err=:testing_in_err,
            analysis_in_err=:analysis_in_err,
            planning_res_err=:planning_res_err,
            infrastructuring_res_err=:infrastructuring_res_err,
            coding_res_err=:coding_res_err,
            code_review_res_err=:code_review_res_err,
            compiling_res_err=:compiling_res_err,
            testing_res_err=:testing_res_err,
            analysis_res_err=:analysis_res_err,
            psp_number=:psp_number
        WHERE idUser=:idUser");
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
        $statement = $db->prepare(" SELECT pd.*,u.email
                                    FROM {$table} AS pd
                                    INNER JOIN users AS u ON u.id=pd.idUser
                                    WHERE idUser = :idUser");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        $result[0]["sum_time"] = array_sum(array_slice($result[0], 2,7));
        $result[0]["sum_in_err"] = array_sum(array_slice($result[0], 9,7));
        $result[0]["sum_res_err"] = array_sum(array_slice($result[0], 16,7));


        foreach(array_keys(array_slice($result[0], 2,21)) as $wbli){
            $name = substr ($wbli,0,strrpos($wbli, '_', -1));
            $name2 = substr ($wbli,strrpos($wbli, '_', -5)+1);
            $result[0]["ratios"][$wbli] =  round((int)$result[0][$wbli]/$result[0]["sum_".$name2] *100,2) ;
        }
            


        $result[0]["minloc"] = 0;
        $result[0]["loch"] = 0;
        $result[0]["miskloc"] = 0;
        $result[0]["ratio"] = 0;
        $result[0]["sfratio"] = 0;

        if($result[0]["size"])
            $result[0]["minloc"] =  round($result[0]["sum_time"]/$result[0]["size"],2);
        $result[0]["loch"] =  round($result[0]["size"]/($result[0]["sum_time"]/60),2);
        $result[0]["miskloc"] =  round($result[0]["sum_res_err"]/($result[0]["size"]/1000),2);
        if(array_sum(array_slice($result[0], 16,4)))
            $result[0]["ratio"]  =  round(array_sum(array_slice($result[0], 16,4))/array_sum(array_slice($result[0], 9,4))*100,2);
        if(($result[0]["compiling_time"]+$result[0]["testing_time"]))
            $result[0]["sfratio"] = round($result[0]["code_review_time"]/($result[0]["compiling_time"]+$result[0]["testing_time"]),2);


        foreach(array_keys(array_slice($result[0],9,14)) as $one){
            $name = substr ($one,0,strrpos($one, '_', -5));
            if($result[0][$name."_time"])
                $result[0]["errh"][$one] = round($result[0][$one]/($result[0][$name."_time"]/60),2);
            else
                $result[0]["errh"][$one] = "/";
        }




        return $result;
    }


    public static function updateData($idUser){
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        // vse prejšnje vrednosti
        $result = self::get_user_psps($idUser)[0];
        // število velikost(LOC)
        $statement = $db->prepare("SELECT sum(units) as size
                                    from tasksusersprojects tup
                                    inner join psps on psps.id=tup.idPSP
                                    inner join psp_tasks pt on psps.id=pt.idPSP
                                    inner join psp_phases pp on pt.idPhase=pp.id
                                    where tup.idUser=:idUser and pp.id=3");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $temp = $statement->fetchAll();
        if($temp!=null)
            $result["size"]=$temp[0]["size"];


        // število psp-jev
        $statement = $db->prepare("SELECT COUNT(*) as num
                                    FROM`tasksusersprojects` 
                                    where idUser=:idUser");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $temp = $statement->fetchAll();
        $result["psp_number"]=$temp[0]["num"];
        
        // število time
        $statement = $db->prepare("SELECT pp.name,sum(TIMESTAMPDIFF(MINUTE,start,end)) as time
                                    from tasksusersprojects tup
                                    inner join psps on psps.id=tup.idPSP
                                    inner join psp_tasks pt on psps.id=pt.idPSP
                                    inner join psp_phases pp on pt.idPhase=pp.id
                                    where tup.idUser=:idUser
                                    group by pp.id");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $temp=$statement->fetchAll();
        foreach($temp as $num){
            $result[strtolower($num["name"])."_time"] = $num["time"];
        }

        // input mistakes
        $statement = $db->prepare("SELECT pp.name,count(pe.id) as err
                                    from tasksusersprojects tup
                                    inner join psps on psps.id=tup.idPSP
                                    inner join psp_errors pe on psps.id=pe.idPSP
                                    inner join psp_phases pp on pe.phaseEntry=pp.id
                                    where tup.idUser=:idUser
                                    group by pp.id");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $temp=$statement->fetchAll();
        foreach($temp as $num){
            $result[strtolower($num["name"])."_in_err"] = $num["err"];
        }

         // resolved mistakes
        $statement = $db->prepare("SELECT pp.name,sum(num_fixed_errors) as fix
                                    from tasksusersprojects tup
                                    inner join psps on psps.id=tup.idPSP
                                    inner join psp_errors pe on psps.id=pe.idPSP
                                    inner join psp_phases pp on pe.phaseFinish=pp.id
                                    where tup.idUser=:idUser
                                    group by pp.id");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        $temp=$statement->fetchAll();
        foreach($temp as $num){
            $result[strtolower($num["name"])."_res_err"] = $num["fix"];
        }
        self::update($result);
    }

}