<?php

class ModelClient extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'first_name', 'last_name', 'email', 'phone', 'address', 'postal_code', 'user_id'];

}
