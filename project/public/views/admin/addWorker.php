<?php require_once ROOT . '/include/header.php'; ?>


    <div class="row content">
    <div class="col-9 AdminBlockContent">
        <form action="" method="post" enctype="multipart/form-data">
            <span class="textForm">Имя:</span>
            <input type="text" name="first_name">
            <span class="textForm">Фамилия:</span>
            <input type="text" name="last_name">
            <span class="textForm">Отчество:</span>
            <input type="text" name="father_name">
            <span class="textForm">birth_day:</span>
            <input type="date" name="birthd_day">
            <span class="textForm">ИНН:</span>
            <input type="number" name="inn">
            <span class="textForm">КНИЛС:</span>
            <input type="number" name="cnils">
            <span>Дата рождения:</span>
            <input type="date" name="data_start_job">
            <span class="textForm">Логотип:</span>
            <input type="file" id="logoWorker"  data-src="<?php echo $src; ?>">
            <input type="hidden" id="logo" name="logo" value="">
            <img src=""  alt="logoWorker" id="imgFile">
            <select name="id_firm">
                <?php foreach ($companies as $item): ?>
                    <option value="<?php echo $item['id_firm']; ?>"><?php echo $item['firm_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="subAddWorker">
        </form>
    </div>
    <div id="debug">

    </div>



<?php require_once ROOT . '/include/footer.php'; ?>