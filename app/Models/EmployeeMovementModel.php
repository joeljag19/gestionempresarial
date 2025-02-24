<?php
namespace App\Models;

use CodeIgniter\Model;

class EmployeeMovementModel extends Model
{
    protected $table = 'employee_movements';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employee_id', 'movement_type', 'movement_date'];
}
