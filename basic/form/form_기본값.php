<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 6.
 * Time: AM 10:57
 */

//기본값 배열 생성
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $defaults = $_POST;
}else{
    $defaults = array('delivery' => 'yes',
                    'size' => 'large',
                    'main_dish' => array("cuke","stinacg"),
                    'sweet' => '케이크',
                    'my_name'=>'뽀라미~',
                    'comments'=>'<html><b>화이팅~</b></html>'
    );

    $sweets = array('puff' => '참깨 퍼프',
        'square' => '코코넛 우유 젤리',
        'cake' => '흑설탕 케이크',
        'ricemeat' => '찹쌀 경단'
    );
    $main_dishes = array('cuke'=>'데친 해삼',
                        'stinacg' => '순대',
                        'tripe' => '와인 소스 양대창',
                        'taro' => '돼지고기 토란국',
                        'giblets' => '곱창 소금 구이',
                        'abalone' => '전복 호밖 볶음'
    );


    print $defaults['sweet'];
}

//텍스트 박스에 기본값 설정
print '<input type-"text" name="my_name" value="'.
        htmlentities($defaults['my_name']). '">';
//텍스트 영역에 기본값 설정
print '<textarea name="comments">';
    print htmlentities($defaults['comments']);
print '</textarea>';


//select 메뉴에 기본값 표시
print '<select name="sweet">';
    //$option은 option이 값, $label은 표시 메뉴 명이다.
    foreach($sweets as $option => $label){
        print '<option value="'.$option.'"';
        if($option == $defaults['sweet']){
            print 'selected';
        };
        print "> $label </option>\n";
    }
print '</select>';

//다중 선택 <select>메뉴에 기본값 설정
print '<select name="main_dish[]" multiple>';
    $selected_option = array();
    if(!is_null($defaults['main_dish'])){ //혹시 모르니까 에러안나게...
        foreach($defaults['main_dish'] as $option){ // defaul기본값에 중복되는 값 true 값을 갖는 새로운 객체 생성
            $selected_option[$option] = true; //{cuke:'true'}
        }
    }
    //<option> 태그 출력
    foreach($main_dishes as $option => $label){
        print '<option value="'.htmlentities($option).'"';
        if(array_key_exists($option, $selected_option)){ //생성한 객체와 key값이 일치하면 선택.
            print 'selected';
        }
        print '>'.htmlentities($label).'</option>';
        print "\n";
    }
print '</select>';
print_r($selected_option);

//체크박스와 라디오 버튼에 기본값 설정
print '<input type="checkbox" name="delivery" value="yes"';
if($defaults['delivery'] == 'yes'){ print ' checked>'; } //default값 과 비교하여 checked선택
print '> 배달 주문이신가요?';
$checkbox_options = array('small' => '소',
                        'medium' => '중',
                        'large' => '대'
);
foreach($checkbox_options as $value => $label){
    print '<input type="radio" name="size" value="'.$value.'"';
        if($defaults['size'] == $value) {print ' checked'; } //default의 key값으로 찾은 value값과 checkbox_option의 반복문으로 갖고온 key값이 비교된다.
    // default:value/checkbox_option:key
    print "> $label";
}
?>

