<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 8. 31.
 * Time: PM 2:42
 */

require '../form/formHelper.php';


//데이터 베이스 접속
try{
    $db = new PDO('mysql:host=localhost;dbname=testDB', 'root','1111');
}catch (PDOException $e){
    print "접속할 수 없습니다.".$e -> getMessage();
    exit();
}

// DB오류와 예외 설정
$db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//페이지의 주 로직 :
// - 폼이 제출되면, 검증 과정을 수행하고 재표시한다.
//- 제출되지 않았으면 폼을 표시한다.
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //validate_form()이 오류룰 반환하면 show_form()으로 전달한다.
    list($errors, $input) = validate_form();
    if($errors){
        show_form();
    }else{
        //제출된 데이터가 올바르면, 처리한다.
        process_form($input);
    }
}else{
    //폼이 제출되지 않았으면 폼을 표시한다.
    show_form();
}

function show_form($errors = array()){
    //기본값 설정. 가격은 $5
    $defaults = array('price' => '5.00');

    //우선시되는 기본값으로 $form객체 생성
    $form = new FormHelper($defaults);

    //폼을 표시하는 모든 HTML은 명확성을 위해 분리된 파일에 둔다.
    include '../form/insert-form.php';
}

function validate_form(){
    $input = array();
    $errors = array();

    //dish_name은 필수값이다.
    $input['dish_name'] = trim($_POST['dish_name'] ?? '');
    if(! strlen($input['dish_name'])){
        $errors[] = '메뉴의 이름을 입력해주세요.';
    }

    //가격은 올바른 부동소수점 수여야 하며 0보다 커야 한다.
    $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    if($input['price'] <= 0){
        $errors[] = '올바른 가격을 입력해주세요';
    }

    //is_spicy의 기본값은 no이다.
    $input['is_spicy'] = $_POST['is_spicy'] ?? 'no';

    return array($errors, $input);
}


function process_form($input){
    //함수 내부에서 전역변수 $db에 접근하기 위해 global로 선언한다.
    global $db;

    // $is_spicy의 값을 checkbox선택값에 따라 설정한다.
    if($input['is_spicy'] == 'yse'){
        $is_spicy = 1;
    }else{
        $is_spicy = 0;
    }

    //신규 메뉴를 테이블에 추가
    try{
        $stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUE(?, ?, ?)');
        $stmt -> execute(array($input['dish_name'], $input['price'], $is_spicy));

        //사용자에게 메뉴를 추가했음을 알림
        print htmlentities($input['dish_name'].'메뉴가 데이터베이스에 추가되었습니다.');
    }catch (PDOException $e){
        print "데이터베이스에 메뉴를 추가할 수 있습니다.";
    }
}
?>
