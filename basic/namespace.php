<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 4.
 * Time: AM 10:49
 */

namespace Tiny;

class Fruit{
    public static function munch($bite){
        print "$bite 한 입 드셔보세요";
    }
}

use Tiny\Fruit as Snack;
use Tiny\Fruit;

Snack::munch("딸기");
Fruit::munch("오랜지");
?>

