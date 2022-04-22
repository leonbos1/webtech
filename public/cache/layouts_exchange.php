<?php class_exists('app\core\Template') or exit; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Cryptoshark</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php $loggedIn = \app\core\Application::$app->LoggedIn();
            if ($loggedIn) { ?>
            <li class="nav-item active">
                <a class="nav-link" href="/wallet">Wallet<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/portfolio">Portfolio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/exchange">Exchange <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="/profile">Profile <span class="sr-only">(current)</span></a>
            </li>

            <?php }
            if (!$loggedIn) { ?>

            <li class="nav-item active float-end">
                <a class="nav-link" href="/login">Login <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active float-end">
                <a class="nav-link" href="/register">Register <span class="sr-only">(current)</span></a>
            </li>

            <?php }
            if ($loggedIn) { ?>
            <li class="nav-item active float-end">
                <a class="nav-link" href="/logout">Logout <span class="sr-only">(current)</span></a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>





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



<?php if (isset($crypto_type)) { ?>

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

                <td><?php echo $price[1] ?></td>
                <?php endforeach; ?>
            </tr>
        </table>
        <div class="scrollable-area">
        </div>
    </div>
</div>


<script src="https://cdn.plot.ly/plotly-2.9.0.min.js"></script>
<script>

    <?php
        $crypto_prices = array();
        $dates = array();

        foreach ($prices as $price) {
            $crypto_prices[] = $price[1];
            $dates[] = $price[0];
        }

    ?>

    function graph(prices, dates) {
        var trace1 = {
            x: dates,
            y: prices,
            mode: 'lines+markers'
        };

        var data = [trace1];

        Plotly.newPlot('crypto-graph', data);
    }
</script>

<style>
    .crypto_graph {
        width: 70%;
    }
</style>
<?php

$crypto_prices = json_encode($crypto_prices);
$dates = json_encode($dates);
echo "<body onload='graph($crypto_prices, $dates)'>";

?>

<div class="crypto_graph" id="crypto-graph"></div>

</body>
<?php } ?>