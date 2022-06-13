<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'specialty_id',
        'professional_id',
        'name',
        'cpf',
        'source_id',
        'birthdate',
        'date_time'];

    protected $table = 'appointments';

    public $timestamps = false;

}
