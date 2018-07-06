<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 4.
 * Time: PM 4:39
 */


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
    print $input_arr['name']."님 안녕하세요.";
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
            이름: <input type="text" name="name">
            <br/>
            나이: <input type="number" name="age">
            <br/>
            가격: <input type="number" name="price">
            <br/>
            날짜 :
            <input type="text" name="year"><input type="text" name="month"><input type="text" name="day">
            <br/>           
            이메일
            <input type="email" name="email">
            <input type="submit" value="인사">
        </form>
_HTML_;
}
//폼 데이터 검사
function validate_form(){
    $errors = array();
    $input = array();

    $input['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, array('options' => array('min_range' => 18, 'max_range' => 65)));
    // FILTER_VALIDATE_INT는 min,max_range 를 지원한다. 이 값은 filter_input 의 4번째 값으로 들어가며 원소가 하나인 배열, 키는 options이다.
    if(is_null($input['age']) || ($input['age'] === false)){
        $errors[] = '18세와 65세 사이의 나이를 입력해 주세요.';
    }

    $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    //FILTER_VALIDATE_FLOAT를 min,max_range를 지원하지 않는다.
    if(is_null($input['price']) || ($input['price'] === false) ||
        ($input['price'] < 10.00) || ($input['price'] > 50.0)) {
        $errors[] = '$10과 $50 사이의 가격을 입력해주세요.';
    }

    //$POST['name']이 설정되지 않았을 경우를 대비해 널 병합 연산자를 사용한다.
    $input['name'] = trim($_POST['name'] ?? '');
    if(strlen($input['name']) == 0){
        $errors[] = '이름을 입력해주세요.';
    }

    //날짜
    //6개월 전을 나타내는 DateTime 객체 생성
    $range_start = new DateTime('6 months ago');
    //현재를 나타내는 DataTime 객체 생성
    $range_end = new DateTime();

    //$_POST['year']가 1900부터 2100 사이의 연도인지 검사한다.
    //$_POST['month']가 1부터 12 사이의 월인지 검사한다.
    //$_POST['day']가 1부터 31 사이의 일인지 검사한다.

    $input['year'] = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1900, 'max_range' => 2100)));
    $input['month'] = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 12)));
    $input['day'] = filter_input(INPUT_POST,'day',FILTER_VALIDATE_INT,array('options' => array('min_array' => 1, 'max_range'=>31)));

    // 연도, 월, 일은 0이 될수 없으므로 항등 연산자를 (===)를 사용할 필요가 없다.
    // 특정 월에 해당하는 일자가 올바른지 확인하고자 checkdate()함수를 사용한다.
    if($input['year'] && $input['month'] && $input['day'] &&
        checkdate($input['month'], $input['day'], $input['year'])){
        print strtotime($input['year'].'-'.$input['month'].'-'.$input['day']);
        $submitted_date = new DateTime(strtotime($input['year'].'-'.$input['month'].'-'.$input['day']));
        if(($range_start > $submitted_date) || ($range_end < $submitted_date)){
            $errors[] = '지난 6개월 사이에 속하는 날짜를 입력해주세요.';
        }
    }else{
        //이 부분은 연도, 월, 일 폼 매개변수 중 하나라도 누락했거나
        //2월 31일처럼 올바르지 않은 날짜를 입력했을 때 수행된다.
        $errors[] = '올바른 날짜를 입력해주세요.';
    }

    //이메일
    $input['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if(! $input['email']){
        $errors[] = '올바른 이메일 주소를 입력해주세요.';
    }

    return array($errors, $input);

//    if(strlen($_POST['my_name'])<3){
//        //return false;
//        $errors = "이름은 3글자 이상 입력해주세요";
//    }//else{
//        //return true;
//    //}
//    return $errors; // 빈배열일 수 있음.
}


//class FormHelper{
//    protected  $values = array();
//
//    public function __construct($values = array()){
//        if($_SERVER['REQUEST_METHOD'] == 'POST'){
//            $this->values = $_POST;
//        }else{
//            $this->values = $values;
//        }
//    }
//
//    public function input($type, $attributes = array(), $isMultiple = false){
//        $attributes['type'] = $type;
//        if(($type == 'radio') || ($type == 'checkbox')){
//            if($this->isOptionSelected($attributes['name'] ?? null,
//                $attributes['value'] ?? null)){
//                $attributes['checked'] = true;
//            }
//        }
//        return $this->tag('input',$attributes, $isMultiple);
//    }
//
//    public function select($options, $attributes = array()){
//        $multiple = $attributes['multiple'] ?? false;
//        return
//            $this->start('select', $attributes, $multiple);
//            $this->options($attributes['name'] ?? null, $options).
//            $this->end('select');
//    }
//
//    public function tag($tag, $attrbutes = array(), $isMulitple = false){
//        return "<$tag ($this->attributes($attributes, $isMulitple)/>";
//    }
//
//    public function start($tag, $attributes = array(), $isMultiple = false){
//        $valueAttribute = (!(($tag == 'select')||($tag == 'textarea')));
//        $attrs = $this->attributes($attributes, $isMultiple, $isMultiple, $valueAttribute);
//        return "<$tag $attrs>";
//    }
//
//    public function end($tag){
//        return "</$tag>";
//    }
//
//    protected function attributes($attributes, $isMultiple, $valueAttribute = true){
//        $tmp = array();
//
//        if($valueAttribute && isset($attributes['name']) &&
//        array_key_exists($attributes['name'], $this -> values)){
//            $attributes['value'] = $this -> values[$attributes['name']];
//        }
//
//        foreach ($attributes as $k => $v){
//            if(is_bool($v)){
//                if($v) { $tmp[] = $this -> encode($k); }
//            }else{
//                $value = $this -> encode($v);
//
//                if($isMultiple && ($k == 'name')){
//                    $value = '[]';
//                }
//
//                $tmp[] = "$k=\"$value\"";
//
//            }
//        }
//        return implode('',$tmp);
//
//    }
//}


?>