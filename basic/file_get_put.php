<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 6. 11.
 * Time: PM 4:44
 */


$get_file = './readme.txt';
echo file_get_contents($get_file);


$put_file = './writeme.txt';
file_put_contents($put_file, 'coding everybody');

?>