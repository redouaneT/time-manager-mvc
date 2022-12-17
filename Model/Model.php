<?php

abstract class Model extends PDO
{

    public function __construct()
    {
        parent::__construct('mysql:host=localhost; dbname=time_manager; port=3306; charset=utf8', 'root', '');
    }

    public function select($champ = 'id', $order = 'ASC')
    {
        $sql = "SELECT * FROM $this->table ORDER BY $champ $order";
 
        $stmt  = $this->query($sql);
      
        return  $stmt->fetchAll();
    }

    public function selectId($value)
    {
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1) {
            return $stmt->fetch();
        } else {
            header("location: ../../home/error");
        }
    }

    public function selectByColumnValue($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = :$column";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$column", $value);

        $stmt->execute();
        if ($stmt) {
            return $stmt->fetchAll();
        } else {
            header("location: ../../home/error");
        }
    }

    public function insert($data)
    {
        $data_keys = array_fill_keys($this->fillable, '');
        $data_map = array_intersect_key($data, $data_keys);
        $nomChamp = implode(", ",array_keys($data_map));
        $valeurChamp = ":".implode(", :", array_keys($data_map));
        $sql = "INSERT INTO $this->table ($nomChamp) VALUES ($valeurChamp)";
   
        $stmt = $this->prepare($sql);
        foreach($data_map as $key=>$value){
            $stmt->bindValue(":$key", $value);
          
        } 
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
        }else{
            return $this->lastInsertId();
        }
    }

    public function update($data, $champId = 'id')
    {
        
        $champRequete = null;
        $data_keys = array_fill_keys($this->fillable, '');
        $data_map = array_intersect_key($data, $data_keys);
        foreach ($data_map as $key => $value) {
            $champRequete .= "$key = :$key, ";
        }

        $champRequete = rtrim($champRequete, ", ");

        $sql = "UPDATE $this->table SET $champRequete WHERE $champId = :$champId";

    

        $stmt = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
        }
    }

    public function delete($id, $champId = 'id', $url = 'client-index.php')
    {

        $sql = "DELETE FROM $this->table WHERE $champId = :$champId";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$champId", $id);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
        }
    }
}
