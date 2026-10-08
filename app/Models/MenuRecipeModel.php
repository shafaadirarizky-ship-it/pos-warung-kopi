<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuRecipeModel extends Model
{
    protected $table            = 'menu_recipes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'menu_id',
        'ingredient_id',
        'jumlah_pakai',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
}
