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



<h1>Portfolio</h1>

<form action="portfolio" method="post">

    <select>
        <option value="none" selected disabled hidden>Kies een valuta</option>
        <?php foreach ($cryptos as $key => $item): ?>
        <option value=<?php echo $key ?>><?php echo $item ?></option>
        <?php endforeach; ?>
    </select>

    <input type="number" min="0">
    <select>
        <option value="none" selected disabled hidden>Kies een valuta</option>
        <?php foreach ($cryptos as $key => $item): ?>
        <option value=<?php echo $key ?>><?php echo $item ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit">

</form>

<p>dfghdsgh</p>

<h1>
    Wallet
</h1>

<p>Deze wallet is van:
    <?php echo $user->username ?>
    </p>

<?php foreach ($wallet->attributes() as $v): ?>

<p><?php echo $v ?>: <?php echo $wallet->$v ?></p>
<?php endforeach; ?>


