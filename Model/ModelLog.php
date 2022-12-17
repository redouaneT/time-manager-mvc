<?php

class ModelLog extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'visitor_username', 'visitor_ip', 'visited_at', 'visited_url'];
}
