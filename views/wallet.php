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

<p>Geld toevoegen:</p>
<form method="post">
    <label>
        <input placeholder="Euro" name="add_euro">
    </label>
    <input type="submit">
</form>
