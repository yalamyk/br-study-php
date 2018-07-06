<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 3.
 * Time: PM 1:32
 */





class Entree{ //클래스 정의
    private $name;
    public $ingredients = array();

    //속성의 가시성 변경
    public function getName(){
        return $this->name;
    }
    public function __construct($name, $ingredients){
        if(! is_array($ingredients)){
            throw new Exception('$ingredients 배열이 아닙니다.');
        }
        $this->name = $name;
        $this->ingredients = $ingredients;
    }
    public function hasIngredient($ingredient){
        return in_array($ingredient, $this -> ingredients); //$this는 함수를 호출하는 현재의 인스턴스를 가르키는 변수.
    }

    public static function getSizes(){ // 정적 메서드  :  $this 사용 불가
        return array('소','중','대');
    }
    //$sizes = Entree::getSizes(); // 정적 메서드의 호출 (->대신 ::)
}


class ComboMeal extends Entree{
    public function __construct($name,$entrees){
        parent::__construct($name,$entrees);
        foreach($entrees as $entree){
            if(! $entree instanceof Entree)
            throw new Exception("$entrees는 객체여야 합니다.");
        }
    }
    public function hasIngredient($ingredient){
        foreach($this->ingredients as $entree){
            if($entree->hasIngredient($ingredient)){
                return true;
            }
        }
        return false;
    }
}

//객체 생성과 사용 : 에러 처리 전
//$soup = new Entree;
//$soup->name = '닭고기 수프';
//$soup->ingredients = array('닭고기', '물');
//
//$sandwich = new Entree;
//$sandwich->name = '닭고기 샌드위치';
//$sandwich->ingredients = array('닭고기', '빵');
//
//foreach(['닭고기', '레몬', '빵', '물'] as $ing){
//    if($soup->hasIngredient($ing)){
//        print "수프의 제료 : $ing.\n";
//    }
//    if($sandwich->hasIngredient($ing)){
//        print "샌드위치의 재료 : $ing.\n";
//    }
//}

////예외처리
//$soup = new Entree('닭고기 수프' , array('닭고기','물'));
//$sandwich = new Entree('닭고기 샌드위치', array('닭고기', '빵'));
////예외 발생
//try{
//    $drink = new Entree('우유 한잔', '우유');
//    if($drink->hasIngredient('우유')){
//        print '맛있어!';
//    }
//}catch(Exception $e){
//    print "음료를 준비할 수 없습니다. : " . $e->getMessage();
//}

//하위클래스 사용
$soup = new Entree('닭고기 수프', array('닭고기','물'));
$sandwich = new Entree('닭고기 샌드위치', array('닭고기','빵'));
$combo = new ComboMeal('수프 + 샌드위치',array($soup, $sandwich));

foreach(['닭고기','물','피클'] as $ing){
    if($combo -> hasIngredient($ing)){
        print "세트 메뉴에 들어가는 재료 : $ing.\n";
    }
}

?>


