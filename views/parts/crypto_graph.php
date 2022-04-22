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