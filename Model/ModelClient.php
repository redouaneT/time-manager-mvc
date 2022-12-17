<?php

class ModelClient extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';
    protected $foreignKey = 'city_id';
    protected $fillable = ['id', 'first_name', 'last_name', 'email', 'phone', 'address', 'city_id', 'postal_code', 'user_id'];

    public function select($value = 'id', $order = 'ASC')
    {
        $sql = "SELECT $this->table.id, $this->table.first_name, $this->table.last_name, $this->table.email, $this->table.phone, $this->table.address, city.name as city_name, country.name as country_name, country.id as country_id, $this->table.postal_code, $this->table.user_id FROM $this->table INNER JOIN city ON $this->table.$this->foreignKey = city.id INNER JOIN country ON city.country_id = country.id ORDER BY $this->table.$value $order";
        var_dump($sql);
        die();
        $stmt  = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function selectByColumnValue($column, $value, $order = 'ASC'){

        $sql = "SELECT $this->table.id, $this->table.first_name, $this->table.last_name, $this->table.email, $this->table.phone, $this->table.address, city.name as city_name, country.name as country_name, country.id as country_id, $this->table.postal_code, $this->table.user_id FROM $this->table INNER JOIN city ON $this->table.$this->foreignKey = city.id INNER JOIN country ON city.country_id = country.id WHERE $this->table.$column = $value ORDER BY $this->table.id $order";
        $stmt  = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function selectId($value)
    {
        $sql = "SELECT $this->table.id, $this->table.first_name, $this->table.last_name, $this->table.email, $this->table.phone, $this->table.address, city.name as city_name, city.id as city_id, country.name as country_name, country.id as country_id, $this->table.postal_code, $this->table.user_id FROM $this->table  INNER JOIN city ON $this->table.$this->foreignKey = city.id INNER JOIN country ON city.country_id = country.id WHERE $this->table.id = $value";
        $stmt  = $this->query($sql);
        return $stmt->fetch();
    }
}
