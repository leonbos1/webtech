<?php class_exists('app\core\Template') or exit; ?>
<h1><?php echo $crypto_type ?></h1>


<div class="box-content box-no-padding">
    <div class="table-responsive" style="width: 60%; margin: 25px;">
        <table class="table table-bordered table-dark" style="margin: 0px">
            <tr>
                <th scope="col">dag</th>
                <?php foreach($prices as $price): ?>
                <td><?php echo $price[0] ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th scope="col">prijs</th>
                <?php foreach($prices as $price): ?>
                <?php if ($price[0]+1 < sizeof($prices)) { ?>
                <td><?php echo $price[1] ?></td>
                <?php } else { ?>
                <td><?php echo $price[1] ?> (actueel)</td>
                <?php } ?>
                <?php endforeach; ?>
            </tr>
        </table>
        <div class="scrollable-area">
        </div>
    </div>
</div>
