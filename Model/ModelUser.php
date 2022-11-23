<?php

class ModelUser extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'username', 'first_name', 'last_name', 'email', 'phone', 'password', 'birthday', 'address', 'postal_code'];
}
