<style>
    .login-error-p {
        color: red;
    }
</style>

<h2> Login </h2>

<form action="/login" method="post">

    <input name="username">
    <input type="password" name="password">
    <input type="submit">


</form>

<?php

if (isset($failMessage)) {
    echo "<p class='login-error-p'> $failMessage </p>";
}

?>