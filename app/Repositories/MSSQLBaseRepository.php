<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

abstract class MSSQLBaseRepository
{
    /**
     * The MSSQL DB instance.
     *
     * @var \Illuminate\Database\Connection
     */
    public $db;

    public function __construct()
    {
        $this->db = DB::connection('sqlsrv');
    }
}
