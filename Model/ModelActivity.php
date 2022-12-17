<?php

class ModelActivity extends Model
{
    protected $table = 'activity';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'type', 'description', 'starts_at', 'ends_at', 'user_id'];
}
