<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 5.
 * Time: PM 6:36
 */

$sweets = array('puff' => '참깨 퍼프',
            'square'=>'코코넛 우유 젤리',
            'cake'=>'흑설탕 케이크',
            'ricemeat'=>'찹쌀 경단');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //print strlen($_POST['my_name']);

    // validate_form이 오류 메시지 배열을 반환하면 show_form()에 전달 된다.
    list($form_errors, $input) = validate_form(); //list의 구조로 validate_form의 반환값을 변환함.

    if($form_errors){
        show_form($form_errors);
    }else{
        process_form($input);
    }
}else{
    show_form(null);
}

//폼 제출시 수행
function process_form($input_arr){
    print $input_arr['order']."을 선택.";
}

function generate_options($options){
    $html = '';
    if(!empty($options)){
        foreach($options as $option){
            $html .= "<option>$option</option>\n";
        }
    }

    return $html;
}
function generate_options_with_value($options){
    $html = '';
    foreach($options as $value => $option){
        $html .= "<option value=\"$value\">$option</option> \n";
    }
    return $html;
}

//폼을 표시하는 함수
function show_form(){
    $sweets = generate_options_with_value($GLOBALS['sweets']);
    print<<<_HTML_
        <form method="post" action="$_SERVER[PHP_SELF]">
            메뉴 선택 : <select name="order">
                $sweets
            </select>
            <br/>
            <input type="submit" value="주문">
        </form>
_HTML_;

}
//폼 데이터 검사
function validate_form(){
    $errors = array();
    $input['order'] = $_POST['order'];
//    if(! in_array($input['order'], $GLOBALS['sweets'])){
    if(! array_key_exists($input['order'], $GLOBALS['sweets'])){
        $errors[] = '주문 가능한 메뉴가 아닙니다.';
    }

    return array($errors, $input);
}

?>