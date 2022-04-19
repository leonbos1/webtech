<h1>
    Wallet
</h1>

<p>Deze wallet is van:
    <?php echo $user->username;
    ?></p>

<?php
foreach ($wallet->attributes() as $v) {
    echo "<p> $v: ". $wallet->$v ."</p>";
}
?>
