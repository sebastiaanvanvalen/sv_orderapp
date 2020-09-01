<?php

try{
    // oude instellingen
    // $db = new PDO('mysql:unix_socket=/var/lib/mysql/prod/mysql.sock;dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


    $db = new PDO('mysql:host=localhost; dbname=testlocalsmitenvoogt', DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch(PDOException $e) {
    print "uh uh uh... You didn't say the magic word" ."\n\n" . $e->getMessage(). "<br><br>";
    die();
}
