<?php

class ModelAppointment extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'description', 'date', 'created_at', 'user_id'];
}
