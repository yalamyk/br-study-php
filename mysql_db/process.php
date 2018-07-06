<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 6. 12.
 * Time: PM 1:45
 */

$link = mysqli_connect("localhost", "root", "brkwonmysql","opentutorials");

$get_title = mysqli_real_escape_string($link, $_POST['title']);
$get_description = mysqli_real_escape_string($link, $_POST['description']);
switch($_GET['mode']){
    case 'insert':
//        $result = mysql_query("INSERT INTO topic (title, description, created) VALUES ('".mysql_real_escape_string($_POST['title'])."', '".mysql_real_escape_string($_POST['description'])."', now())");
        $result = mysqli_query($link,"INSERT INTO topic (title, description, created) VALUES ('".$get_title."', '".$get_description."', now())");
        header("Location: list.php");
        break;
    case 'delete':
        mysql_query('DELETE FROM topic WHERE id = '.mysql_real_escape_string($_POST['id']));
        header("Location: list.php");
        break;
    case 'modify':
        mysql_query('UPDATE topic SET title = "'.mysql_real_escape_string($_POST['title']).'", description = "'.mysql_real_escape_string($_POST['description']).'" WHERE id = '.mysql_real_escape_string($_POST['id']));
        header("Location: list.php?id={$_POST['id']}");
        break;
}
?>

<!--mysql_real_escape_string : 보안과 관련된 부분 (삽입 공격 대응)-->
