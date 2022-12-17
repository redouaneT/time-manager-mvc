<?php

class ModelUser extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $foreignKey = 'city_id';
    protected $fillable = ['id', 'username', 'first_name', 'last_name', 'email', 'phone', 'city_id', 'password', 'birthday', 'address', 'privilege_id', 'postal_code'];

    public function select($value = 'id', $order = 'ASC')
    {
        $sql = "SELECT $this->table.id, $this->table.username, $this->table.first_name, $this->table.last_name, $this->table.email, $this->table.password,  $this->table.birthday, $this->table.address, city.name as city_name, country.name as country_name, country.id as country_id, $this->table.postal_code, $this->table.privilege_id FROM $this->table INNER JOIN city ON $this->table.$this->foreignKey = city.id INNER JOIN country ON city.country_id = country.id ORDER BY $this->table.$value $order";
      
        $stmt  = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function selectId($value)
    {
        $sql = "SELECT $this->table.id, $this->table.username, $this->table.first_name, $this->table.last_name, $this->table.email, $this->table.password, $this->table.birthday, $this->table.address, city.name as city_name, city.id as city_id, country.name as country_name, country.id as country_id, $this->table.postal_code, $this->table.privilege_id, privilege.name as privilege FROM $this->table  INNER JOIN city ON $this->table.$this->foreignKey = city.id INNER JOIN privilege ON $this->table.privilege_id = privilege.id INNER JOIN country ON city.country_id = country.id WHERE $this->table.id = $value";
        // var_dump($sql);
        // die();
        $stmt  = $this->query($sql);
        return $stmt->fetch();
    }

    public function checkUser($data){

        extract($data);
        $sql = "SELECT * FROM $this->table WHERE username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute(array($username));
        $count = $stmt->rowCount();
        if($count == 1){
            $user_info = $stmt->fetch();
            if(password_verify($password, $user_info['password'])){
                session_regenerate_id();
                $_SESSION['user_id'] = $user_info['id'];
                $_SESSION['privilege_id'] = $user_info['privilege_id'];
                $_SESSION['username'] = $user_info['username'];
                $_SESSION['email'] = $user_info['email'];
                $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
                requirePage::redirectPage('home/index');
            }else{
               return "<ul><li>Verifier le mot de passe</li></ul>";  
            }
        }else{
            return "<ul><li>Le non d'utilisateur n'exist pas</li></ul>";
        }
    } 
}
