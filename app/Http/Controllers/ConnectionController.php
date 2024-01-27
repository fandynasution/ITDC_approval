<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ConnectionController extends Controller
{
    public function index() {
        try {
           $dbconnect = DB::connection('ITDC')->getPDO();
           $dbname = DB::connection('ITDC')->getDatabaseName();
           echo "Connected successfully to the database. Database name is :".$dbname;
        } catch(Exception $e) {
           echo "Error in connecting to the database";
        }
     }
}
