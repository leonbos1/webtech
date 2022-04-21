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


<h1>Exchange (<?php echo $crypto_type ?>)</h1>

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


