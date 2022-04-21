<?php class_exists('app\core\Template') or exit; ?>
<h1>Exchange</h1>
<div class="box-content box-no-padding">

    <form action="/exchange" method="post">
        <select name="crypto" onchange="this.form.submit()">
            <option value="none" selected disabled hidden>Kies een crypto</option>
            <?php foreach ($cryptos as $key => $item): ?>
            <option value=<?php echo $key ?>><?php echo $item ?></option>
            <?php endforeach; ?>

        </select>
    </form>

</div>

