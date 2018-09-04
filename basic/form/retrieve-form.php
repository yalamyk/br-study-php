<?php
/**
 * Created by PhpStorm.
 * User: brkwon
 * Date: 2018. 9. 3.
 * Time: PM 2:43
 */

?>


<form action="<?= $form-> encode($_SERVER['PHP_SELF']) ?>" method="POST">
    <table>
        <?php if($errors){?>
            <tr>
                <td>다음 항목을 수정해주세요.</td>
                <td>
                    <ul>
                        <?php foreach($errors as $error) { ?>
                        <li><?= $form -> encode($errors)  ?> </li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        <?php }?>
        <tr>
            <td>메뉴 이름</td>
            <td><?= $form -> input('text', ['name' => 'dish_name']) ?></td>
        </tr>
        <tr>
            <td>최소 가격 : </td>
            <td><?= $form->input('text',['name' => 'min_price']) ?></td>
        </tr>
        <tr>
            <td>최대 가격 : </td>
            <td><?= $form->input('text', ['name' => 'max_price']) ?></td>
        </tr>

        <tr>
            <td>맵기 : </td>
            <td><?= $form -> select($GLOBALS['spicy_choices'],['name'=>'is_spicy']) ?></td>
        </tr>


        <tr>
            <td colspan="2" align="center">
                <?= $form-> input('submit', ['name' => 'dishes', 'value' => '검색']) ?>
            </td>
        </tr>
    </table>
</form>