<?php

class ModelCity extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'id';
    protected $foreignKey = 'country_id';

    public function selectByForeignKey($value, $order = 'ASC', $script = false)
    {
        $sql = "SELECT * FROM $this->table WHERE $this->foreignKey = $value ORDER BY name $order";
        $stmt  = $this->query($sql);
        if ($script == 'true') {
            return  json_encode($stmt->fetchAll()) ;
        }else{
            return  $stmt->fetchAll();
        }
    }

    // public function selectId($value, $order = 'ASC')
    // {
    //     $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = $value INNER JOIN country ON $this.table.$this->foreignKey = country.id ORDER BY name $order";
    //     $stmt  = $this->query($sql);
    //     return $stmt->fetch();
    // }
}