<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= asset_url('css/errors/405.css') ?>">
    <title>405: Method Not Allowed</title>
</head>

<body>
    <div id="not-allowed">
        <div class="not-allowed">
            <div class="not-allowed-bg">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <h1>oops!</h1>
            <h2>Error 405: Method Not Allowed!</h2>
            <a href='<?= $_ENV['BASEURL'] ?>'>GO HOME</a>
        </div>
    </div>
</body>

</html>