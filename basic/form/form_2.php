<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 4.
 * Time: PM 4:39
 */


if($_SERVER['REQUEST_METHOD'] == 'POST'){
//    print strlen($_POST['my_name']);
    if($form_errors = validate_form()){
        show_form($form_errors);
    }else{
        process_form();
    }
}else{
    show_form(null);
}

//폼 제출시 수행
function process_form(){
    print $_POST['my_name']."님 안녕하세요.";
}
//폼 표시
function show_form($errors){
    if($errors){
        print "다음 항목을 수정해주세요. : <ul><li>";
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }
    print<<<_HTML_
        <form method="POST" action="$_SERVER[PHP_SELF]">
            이름: <input type="text" name="my_name">
            <br/>
            <input type="submit" value="인사">
        </form>
_HTML_;
}
//폼 데이터 검사
function validate_form(){
    $errors = array();

    if(strlen($_POST['my_name'])<3){
        //return false;
        $errors[] = "이름은 3글자 이상 입력해주세요";
    }//else{
        //return true;
    //}
    return $errors; // 빈배열일 수 있음.
}

?>