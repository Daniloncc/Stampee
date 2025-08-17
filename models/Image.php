<?php

namespace App\Models;

use App\Models\CRUD;

class Image extends CRUD
{
    protected $table = "Image";
    protected $primaryKey = "id";
    protected $fillable = ['image', 'lien', 'idTimbre'];
}
