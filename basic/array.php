<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 7. 4.
 * Time: PM 5:15
 */


$row_styles = array('even'. 'odd');
$style_index = 0;

$meal = array('breakfast' => '호두번',
            'lunch' => '캐슈너트와 양송이버섯',
            'snack' => '말린 오디',
            'dinner' => '칠리 소스 가지 볶음');

print<<<_HTML_
    <table>
_HTML_;
foreach($meal as $key => $value){
    print<<<_HTML_
        <tr class="' .$row_styles[$style_index]. '">
            <td style="border: solid 1px #000;">$key</td>
            <td style="border: solid 1px #000;">$value</td>
        </tr>
_HTML_;
$style_index = 1 - $style_index;
}
print<<<_HTML_
    </table>
_HTML_;




?>