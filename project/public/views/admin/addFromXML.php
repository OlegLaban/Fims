<?php
    require ROOT . "/views/include/header.php";
?>

<div class="row content">
    <div class="col-9 AdminBlockContent">
        <form action="" method="post" enctype="multipart/form-data">
            <p>Загрузка данных через XML файл.</p>
            <input type="file" name="filename">
            <input type="submit" name="subAddXml">
        </form>
    </div>
    <div id="debug">

    </div>

<?php
require ROOT . "/views/include/footer.php";
?>
