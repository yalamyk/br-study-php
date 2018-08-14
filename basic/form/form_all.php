<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 6.
 * Time: PM 1:32
 */



require 'formHelper.php';

//select 메뉴의 선택 항목 배열 생성
//이 배열은 display_form(), validate_form(), process_form()에서 사용되므로
//전역 영역에 선언한다.

$sweets = array('puff'=>'참깨 퍼프',
                'square'=>'코코넛 우유 젤리',
                'cake'=>'흑설탕 케이크',
                'ricecake'=>'찹쌀 경단'
);
$main_dishes = array('cuke'=>'데친 해삼',
                    'stomach'=>'순대',
                    'tripe'=>'와인 소스 양대창',
                    'taro'=>'돼지고기 토란국',
                    'giblets'=>'곱창 소금 구이',
                    'abalone'=>'전복 호박 볶음'
);

//메인 페이지 로직
//-폼에 제출되면, 검증 과정을 거쳐 처리하거나 폼을 다시 출력하고
//-제출되지 않았으면 폼을 출력한다.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //validate_form이 오류메시지를 반환하면 show_form()로 전달
    list($errors, $input) = validate_form();
    if($errors){
        show_form($errors);
    }else{
        //제출 데이터가 검증을 통과하면 처리한다.
        process_form($input);
    }
}else{
    //폼이 제출되지 않았으면 폼을 출력한다.
    show_form();
}

function show_form($errors = []){
    $defaults = array('delivery' => 'yes',
                    'size' => 'medium'
    );
    //기본값을 이용해 $form객체를 생성한다.
    $form = new FormHelper($defaults);

    //폼 출력과 관련된 모든 HTML은 별도의 파일로 완전히 분리한다.
    include 'complete-form.php';
}

function validate_form(){
    $input = array();
    $errors = array();

    //name은 필수 항목이다.
    $input['name'] = trim($_POST['name'] ?? '');
    if(! strlen($input['name'])){
        $errors[] ='이름을 입력해주세요.';
    }

    //size 필수 항목이다.
    $input['size'] = $_POST['size'] ?? '';
    if(! in_array($input['size'],['small','medium','large'])){
        $errors[] ='크기를 선택해주세요.';
    }

    //sweet 필수 항목이다.
    $input['sweet'] = $_POST['sweet'] ?? '';
    if(! array_key_exists($input['sweet'], $GLOBALS['sweets'])){
        $errors[] ='디저트를 선택해주세요.';
    }

    //정확히 두가지의 주 요리를 선택해야 한다.
    $input['main_dish'] = $_POST['main_dish'] ?? array();
    if(count($input['main_dish']) !== 2){
        $errors[] = '주 요리를 두가지 선택해주세요.';
    }else{
        //주 요리가 두가지 선택되었다면, 두요리가 모두 유효한지 검사
        if(!(array_key_exists($input['main_dish'][0], $GLOBALS['main_dishes']) &&
            array_key_exists($input['main_dish'][1], $GLOBALS['main_dishes']))){
            $errors[]= '주 요리를 두 가지 선택해주세요.';
        }
    }

    //delivery 가 선택됐으면 comments에 내용이 있어야 한다.
    $test = $_POST['delivery'];
    print('$test ::: '.$test);
    $input['delivery'] = $_POST['delivery'] ?? 'no';
    print('delivery ::: '.$input['delivery']);
    $input['comments'] = trim($_POST['comments'] ?? '');
    if(($input['delivery'] == 'yes') && (! strlen($input['comments']))){
        $errors[] = '배달 주소를 입력해주세요.';
    }
    return array($errors, $input);
}


function process_form($input){
    //디저트와 주 요리의 전체이름을 $GLOBALS['sweets'] $GLOBAL['main_dishes']배열에서 찾는다.
    $sweet = $GLOBALS['sweets'][$input['sweet']];
    $main_dish_1 = $GLOBALS['main_dishes'][$input['main_dish'][0]];
    $main_dish_2 = $GLOBALS['main_dishes'][$input['main_dish'][1]];

    print($input['delivery']);
    if(isset($input['delivery']) && ($input['delivery'] == 'yes')){
        $delivery = '배달';
    }else{
        $delivery = '매장 방문';
    }
    //주문 메시지 텍스트 생성
    $message=<<<_ORDER_
        주문이 완료되었습니다, {$input['name']}님
        $sweet({$input['size']}), $main_dish_1, $main_dish_2 를 주문하셨습니다.
        배달 여부 : $delivery ,
_ORDER_;
    $message.=trim($input['comment']);
    if (strlen(trim($input['comment']))){
        $message .= '남기신 메모'.$input['comment'];
    }

    //주방장에게 메시지 보내기
    mail('yalamyk@gmail.com', 'New Order', $message);

    //HTML엔티티 인코딩 후 메시지를 출력하고
    //줄 바꿈은 <br/>태그로 변경한다.
    print nl2br(htmlentities($message, ENT_HTML5));

}

?>