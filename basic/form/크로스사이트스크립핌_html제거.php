<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 6.
 * Time: AM 10:48
 */

//댓글에서 HTML 제거하기
$comments = strip_tags($_POST['comments']);
//이제 안전하게 $commets 를 출력할 수 있음
print $comments;


//html을 엔티티로 변경 (<,>,&,")
$comments = htmlentities($_POST['comments']);
print $comments;

?>