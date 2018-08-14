<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 8. 14.
 * Time: PM 3:41
 */

try{
    $db = new PDO('mysql:host=localhost;dbname=testDB',"root","1111");
}catch (Exception $e){
    print "접속할 수 없습니다. : ".$e->getMessage();
}

/*
 * PDO는 예외, 침묵, 경고 3가지 모드로 작동을 한다.
 */

//침묵모드 : 기본모드
//생성자는 실행실패시 항상 예외를 발생시킨다.
$result = $db->exec("INSERT INTO dishes(dish_size, dish_name, price, is_spicy)
                    VALUES('대','참깨 퍼프', 2.50, 0)");
if(false === $result){
    $error = $db->errorInfo();
    print "데이터를 삽입할 수 없습니다.\n";
    print "SQL Error = {$error[0]}, DB Error={$error[1]}, Message={$error[2]}\n";
}


//경고모드
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
$result = $db->exec("INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
            VALUES('대', '참깨 퍼프', 2.50, 0)");
if(false === $result){
    $error = $db -> errorInfo();
    print "데이터를 추가할 수 없습니다.\n";
    print "SQL Error = {$error[0]}, DB Error={$error[1]}, Message={$error[2]}\n";
}

