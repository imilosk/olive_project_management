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
        $statement = $db->prepare(" INSERT INTO {$table} VALUES (null)");
        $statement->execute();
    }

    public static function delete($id) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM {$table} WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
    } 


    public static function get_psp_data($idPSP) {
        $table = self::TABLE_NAME;
        $db = DBInit::getInstance();


        
        $statement = $db->prepare(" SELECT idUser,sum(estimatedunits) as p_size, sum(units) as a_size
                                    from {$table} as psps
                                    inner join tasksusersprojects tup on tup.idPSP=psps.id
                                    inner join psp_tasks pt on psps.id=pt.idPSP
                                    inner join psp_phases pp on pt.idPhase=pp.id
                                    where pp.id=3 and psps.id=:idPSP");
        $statement->bindParam(":idPSP", $idPSP, PDO::PARAM_INT);
        $statement->execute();
        $result[]=$statement->fetchAll()[0];

        $result[]=array_fill_keys(PSPPhase::get_all(), array_fill_keys(["estimatedtime","time"],0));

        $statement = $db->prepare(" SELECT pp.name,sum(estimatedtime) as estimatedtime,sum(TIMESTAMPDIFF(MINUTE,start,end)) as time
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
            $result[1][$phase] = $row;
        }
        $result[1]["sum"]=$sum;


        $result[]=array_fill_keys(PSPPhase::get_all(), array_fill_keys(["err"],0));
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
            $result[2][$phase] = $row;
        }
       $result[2]["sum"]=$sum;

        $result[]=array_fill_keys(PSPPhase::get_all(), array_fill_keys(["fix"],0));
        $statement = $db->prepare(" SELECT pp.name, sum(num_fixed_errors) as fix
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
             $sum+= $row["fix"];
            $phase = $row["name"];
            unset($row["name"]);
            $result[3][$phase] = $row;
        }
        $result[3]["sum"]=$sum;

        $result[]=UserPSPData::get_user_psps($result[0]["idUser"])[0];

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