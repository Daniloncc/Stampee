<?php

namespace App\Models;

use App\Models\CRUD;

class Image extends CRUD
{
    protected $table = "Image";
    protected $primaryKey = "id";
    protected $foreignKey = "idTimbre";
    protected $fillable = ['image', 'lien', 'idTimbre'];

    public function checkImage($lien)
    {
        $image = $this->unique('lien', $lien);
        if ($image) {
            return true;
        } else {
            return false;
        }
    }
}
