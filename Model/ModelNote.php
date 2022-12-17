<?php

class ModelNote extends Model
{
    protected $table = 'note';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title', 'content', 'user_id'];
}
