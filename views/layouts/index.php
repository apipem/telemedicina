<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redireccionamiento</title>
</head>
<body>
<script>
     alert("Debes iniciar sesión.");
    window.location.href = '<?= Yii::$app->getUrlManager()->createUrl('login') ?>';
</script>
</body>
</html>
