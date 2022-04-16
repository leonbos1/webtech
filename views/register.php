<style>
    .register-error-p {
        color: red;
    }
</style>

<h2> Register </h2>

<form action="/register" method="post">

    <input name="username">
    <input type="password" name="password">
    <input type="submit">


</form>

<?php

if (isset($failMessage)) {
    echo "<p class='register-error-p'> $failMessage </p>";
}

?>