<?php

require_once __DIR__ . '/../settings/DBInit.php';
require_once __DIR__ . '/PSP.php';
require_once __DIR__ . '/UserPSPData.php';

class PSP {

    const TABLE_NAME = 'psps';

/*
    public static function get_all($idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM {$table} WHERE idProject = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
*/

    public static function get($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT id 
                                    FROM {$table} 
                                    WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }

    public static function insert() {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" INSERT INTO {$table} (programing_language) VALUES (null)");
        $statement->execute();
        return $db->lastInsertId();
    }

    public static function update($idPSP,$prog_lang) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" UPDATE {$table} SET programing_language=:prog_lang WHERE id=:idPSP");
        $statement->bindParam(":prog_lang", $prog_lang);
        $statement->bindParam(":idPSP", $idPSP);
        $statement->execute();
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
    } 

    public static function get_psp_data($idUser, $idTask) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();

        $statement = $db->prepare(" SELECT tup.idUser,idPSP,u.email as leaderEmail, programing_language,t.name as task ,ts.name as status
                                    from {$table} 
                                    inner join tasksusersprojects tup on psps.id=tup.idPSP
                                    inner join tasks t on tup.idTask=t.id
                                    inner join projects p on t.idProject=p.id
                                    inner join users u on p.idLeader=u.id
                                    inner join task_status ts on ts.id=t.idTask_status
                                    where  tup.idUser = :idUser and tup.idTask = :idTask");
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->bindParam(":idTask", $idTask, PDO::PARAM_INT);
        $statement->execute();
        $result["info"]=$statement->fetchAll()[0];

        $idPSP = $result["info"]["idPSP"];

        $result["size"]["p_size"] =0;
        $result["size"]["a_size"] =0;

        $statement = $db->prepare(" SELECT sum(estimatedunits) as p_size, sum(units) as a_size
                                    from {$table} as psps
                                    inner join tasksusersprojects tup on tup.idPSP=psps.id
                                    inner join psp_tasks pt on psps.id=pt.idPSP
                                    inner join psp_phases pp on pt.idPhase=pp.id
                                    where pp.id=3 and psps.id=:idPSP");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        $result["size"]=$statement->fetchAll()[0];

        if($result["size"]["p_size"]===null)
            $result["size"]["p_size"]=0;
        if($result["size"]["a_size"]===null)   
            $result["size"]["a_size"]=0;

        $result["time"]=array_fill_keys(PSPPhase::get_all(), array_fill_keys(["estimatedtime","time"],0));

        $statement = $db->prepare(" SELECT pp.name,sum(estimatedtime) as estimatedtime,sum(TIMESTAMPDIFF(MINUTE,start,end))-sum(pause) as time
                                    from {$table}
                                    inner join psp_tasks pt on psps.id=pt.idPSP
                                    inner join psp_phases pp on pt.idPhase=pp.id
                                    where psps.id=:idPSP
                                    group by pp.id");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        $part=$statement->fetchAll(PDO::FETCH_NAMED);

        $sum = array_fill_keys(["plan_time","real_time"],0);
        foreach($part as $row){
            $sum["plan_time"]+= $row["estimatedtime"];
            $sum["real_time"]+= $row["time"];
            $phase = $row["name"];
            unset($row["name"]);
            $result["time"][$phase] = $row;
        }
        $result["time"]["sum"]=$sum;
        $result["time"]["Code_review"] = $result["time"]["Code review"];
        unset($result["time"]["Code review"]);

        $result["err"]=array_fill_keys(PSPPhase::get_all(), array_fill_keys(["err"],0));
        $statement = $db->prepare(" SELECT pp.name,count(pe.id) as err
                                    from {$table}
                                    inner join psp_errors pe on psps.id=pe.idPSP
                                    inner join psp_phases pp on pe.phaseEntry=pp.id
                                    where psps.id=:idPSP
                                    group by pp.id");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        $part=$statement->fetchAll(PDO::FETCH_NAMED);
        
        $sum = 0;
        foreach($part as $row){
            $sum+= $row["err"];
            $phase = $row["name"];
            unset($row["name"]);
            $result["err"][$phase] = $row;
        }
        $result["err"]["sum"]=$sum;
        $result["err"]["Code_review"] = $result["err"]["Code review"];
        unset($result["err"]["Code review"]);

        $result["res"]=array_fill_keys(PSPPhase::get_all(), array_fill_keys(["res"],0));
        $statement = $db->prepare(" SELECT pp.name, sum(num_fixed_errors) as res
                                    from {$table}
                                    inner join psp_errors pe on psps.id=pe.idPSP
                                    inner join psp_phases pp on pe.phaseFinish=pp.id
                                    where psps.id=:idPSP
                                    group by pp.id");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        $part=$statement->fetchAll(PDO::FETCH_NAMED);

        $sum = 0;
        foreach($part as $row){
            $sum+= $row["res"];
            $phase = $row["name"];
            unset($row["name"]);
            $result["res"][$phase] = $row;
        }

        $result["res"]["sum"]=$sum;
        $result["res"]["Code_review"] = $result["res"]["Code review"];
        unset($result["res"]["Code review"]);

        $result["user"]=UserPSPData::get_user_psps($result["info"]["idUser"])[0];

        $summary = [];
        $summary["minloc"] = 0;
        $summary["loch"] = 0;
        $summary["miskloc"] = 0;
        $summary["ratio"] = 0;
        $summary["sfratio"] = 0;
        $temp=($result["user"]["size"] - $result["size"]["a_size"]);

        if($temp)
            $summary["minloc"] = round(($result["user"]["sum_time"] - $result["time"]["sum"]["real_time"])/$temp,2);

        $temp=round(($result["user"]["sum_time"] - $result["time"]["sum"]["real_time"])/60,2);
        if($temp)
            $summary["loch"] = round(($result["user"]["size"] - $result["size"]["a_size"])/$temp,2);

        $temp=(($result["user"]["size"] - $result["size"]["a_size"])/1000);
        if($temp)
            $summary["miskloc"] = round(($result["user"]["sum_res_err"]-$result["res"]["sum"])/$temp,2);

        $temp = ($result["user"]["planning_in_err"]-$result["err"]["Planning"]["err"]+
                $result["user"]["infrastructuring_in_err"]-$result["err"]["Infrastructuring"]["err"]+
                $result["user"]["code_review_in_err"]-$result["err"]["Code_review"]["err"]+
                $result["user"]["coding_in_err"]-$result["err"]["Coding"]["err"]);

        if($temp)
            $summary["ratio"]  = 100*round(($result["user"]["planning_res_err"]-$result["res"]["Planning"]["res"]+
            $result["user"]["infrastructuring_res_err"]-$result["res"]["Infrastructuring"]["res"]+
            $result["user"]["code_review_res_err"]-$result["res"]["Code_review"]["res"]+
            $result["user"]["coding_res_err"]-$result["res"]["Coding"]["res"])/$temp,2);
            
        $temp=($result["user"]["compiling_time"]-$result["time"]["Compiling"]["time"]+$result["user"]["testing_time"]-$result["time"]["Testing"]["time"]);

        if($temp)
            $summary["sfratio"] = round(($result["user"]["code_review_time"]-$result["time"]["Code_review"]["time"])/$temp,2);

        $result["summary"]["plan"] = $summary;

        $summary = [];
        $summary["minloc"] = 0;
        $summary["loch"] = 0;
        $summary["miskloc"] = 0;
        $summary["ratio"] = 0;
        $summary["sfratio"] = 0;

        if ($result["size"]["a_size"])
            $summary["minloc"] = round($result["time"]["sum"]["real_time"]/$result["size"]["a_size"],2);

        if ($result["time"]["sum"]["real_time"]/60)
            $summary["loch"] = round($result["size"]["a_size"]/($result["time"]["sum"]["real_time"]/60),2);

        if ($result["size"]["a_size"]/1000)
            $summary["miskloc"] = round($result["res"]["sum"]/($result["size"]["a_size"]/1000),2);

        $temp = ($result["err"]["Planning"]["err"]+
                $result["err"]["Infrastructuring"]["err"]+
                $result["err"]["Code_review"]["err"]+
                $result["err"]["Coding"]["err"]);

        if($temp)
            $summary["ratio"]  = round(($result["res"]["Planning"]["res"]+
            $result["res"]["Infrastructuring"]["res"]+
            $result["res"]["Code_review"]["res"]+
            $result["res"]["Coding"]["res"])/$temp*100,2);

        if($result["time"]["Compiling"]["time"]+$result["time"]["Testing"]["time"])
            $summary["sfratio"] = round($result["time"]["Code_review"]["time"]/($result["time"]["Compiling"]["time"]+$result["time"]["Testing"]["time"]),2);

        $result["summary"]["real"] = $summary;

        return $result;
    }


/*
    public static function get_user_tasks($idUser, $idProject) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare(" SELECT t.id,t.name
                                    FROM {$table} AS t
                                    INNER JOIN tasksusersprojects AS tup ON t.id=tup.idTask
                                    WHERE tup.idUser = :idUser AND t.idProject = :idProject");
        $statement->bindParam(":idProject", $idProject, PDO::PARAM_INT);
        $statement->bindParam(":idUser", $idUser, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
*/
    
}