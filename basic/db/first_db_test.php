<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 8. 14.
 * Time: PM 2:39
 */

try{
    $db = new PDO('mysql:host=localhost;dbname=testDB', 'root','1111');
    print "Connected successfully!";

}catch(PDOException $e){
    print "데이터베이스에 접속할 수 없습니다 : ".$e->getMessage();
}

//$servername = "localhost";
//$username = "root";
//$password = "1111";
//
//try {
//    $conn = new PDO("mysql:host=$servername;dbname=testDB", $username, $password);
//    // set the PDO error mode to exception
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
//}
//catch(PDOException $e)
//{
//    echo "Connection failed: " . $e->getMessage();
//}


?>
<h1>Connect Test</h1>

