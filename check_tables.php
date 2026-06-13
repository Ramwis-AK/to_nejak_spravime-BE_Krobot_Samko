<?php

use Illuminate\Support\Facades\DB;

$tables = DB::select("select name from sqlite_master where type='table' order by name");
foreach ($tables as $t) {
    echo $t->name . "\n";
}
