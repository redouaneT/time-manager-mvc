<?php

class ModelActivity extends Model
{
    protected $table = 'activity';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'description', 'starts_at', 'ends_at', 'created_at', 'user_id'];

}
