<?php

include("misc/vendor/simple-php-captcha-master/simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
        <?php

echo "<br>";
echo "print_r(_SESSION['captcha'])=";
echo "<br>";
print_r($_SESSION['captcha']);
echo "<br>";
echo "<br>";

        echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';

        ?>

</body>
</html>
