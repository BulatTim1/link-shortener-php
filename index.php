<?php
if (isset($_GET['u'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/app/libs/Database.php';
    function getLink($url)
    {
        $sql = "SELECT * FROM links WHERE short_link = :url";
        $result = Database::query($sql, ['url' => $url], true);
        return $result[0]['link'];
    }

    try {
        header('Location: '. getLink($_GET['u']));
        exit();
    } catch (PDOException $e) {
        echo "<script>document.getElementById('link').innerHTML = Неправильный код</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Link Shortener</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 mb-3 fw-bold">Сокращатель ссылок</h1>
    <div class="col-lg-6 mx-auto">
        <div class="justify-content-sm-center">
            <form class="p-4 p-md-5 border rounded-3 bg-light">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="url" name="url" placeholder="domain.com" required>
                    <label for="url">Адрес </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Создать ссылку</button>
                <hr class="my-4">
                <a id="link" href="#"></a>
            </form>
        </div>
    </div>
</div>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
