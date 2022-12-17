<?php

class ModelCountry extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'id';

    // public function select($champ = 'id', $order = 'ASC')
    // {
    //     $sql = "SELECT * FROM $this->table INNER JOIN Country ON $this->table.country_id = country.id";
    //     // var_dump($sql);
    //     //  die();
    //     $stmt  = $this->query($sql);
    //     return  $stmt->fetchAll();
    // }

}