<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 4.
 * Time: AM 11:54
 */

print "제출된 값은 다음과 같습니다 : ";
print "product_id : ".$_POST['product_id'] ?? '';
print "category : ".$POST['category'] ?? '';


if(isset($_POST['lunch'])){
    foreach($_POST['lunch'] as $choice){
        print "$choice 번을 골랐습니다.";
    }
}

?>