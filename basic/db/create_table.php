<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 8. 14.
 * Time: PM 3:29
 */


try{
    $db = new PDO('mysql:host=localhost;dbname=testDB', 'root','1111');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $q = $db -> exec("CREATE TABLE dishes(
        dish_id INT,
        dish_name VARCHAR(255),
        price DECIMAL(4,2),
        is_spicy INT
    )");
}catch (Exception $e){
    print "테이블을 생성할 수 없습니다. : ".$e->getMessage();
}
// --> 생성 명령어
//CREATE TABLE dishes{
//    dish_id INSERT PRIMARY KEY,
//    dish_name VARCHAR(255),
//    price DECOMAL(4,2),
//    is_spicy INT
//}

