<?php
    require_once ROOT . '/views/include/header.php';
?>
<div class="row content">
    <div class="col-9 AdminBlockContent">
        <h2 class="namePage">Admin/Edit Woker</h2>
        <form action="" method="post" enctype="multipart/form-data" class="filterForm addUser" id="formEditUser">
            <span class="textForm">Имя:</span>
            <input type="text" name="first_name" value="<?php echo $arrDataWoker['first_name']; ?>">
            <span class="textForm">Фамилия:</span>
            <input type="text" name="last_name" value="<?php echo $arrDataWoker['last_name']; ?>">
            <span class="textForm">Отчество:</span>
            <input type="text" name="father_name" value="<?php echo $arrDataWoker['father_name']; ?>">
            <span class="textForm">birth_day:</span>
            <input type="date" name="birthd_day" value="<?php echo Other::getData($arrDataWoker['birthd_day']); ?>">
            <span class="textForm">ИНН:</span>
            <input type="number" name="inn" value="<?php echo $arrDataWoker['inn']; ?>">
            <span class="textForm">КНИЛС:</span>
            <input type="number" name="cnils" value="<?php echo $arrDataWoker['cnils']; ?>">
            <span>Дата рождения:</span>
            <input type="date" name="data_start_job" value="<?php echo Other::getData($arrDataWoker['data_start_job']); ?>">
            <span class="textForm">Логотип:</span>
            <input type="file" id="logoCompanyOrWorker"  data-src="<?php echo $src; ?>">
            <input type="hidden" id="logo" name="logo" value="site/AddImgW">
            <img src="/assets/img/<?php echo  $arrDataWoker['photo']; ?>"  alt="logoWorker" id="imgFile">
            <select name="id_firm">
                <option value="">Выберете компанию.</option>
                <?php foreach ($companies as $item): ?>
                    <option value="<?php echo $item['id_firm']; ?>"
                        <?php if($item['id_firm'] === $arrDataWoker['id_firm']){ echo "selected='select'"; } ?>
                    ><?php echo $item['firm_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="subAddWorker" class="button" value="Изменить">
            <input type="button" name="resetData" id="resetData" class="button" value="Сбросить">
        </form>
    </div>
    <div id="debug">

    </div>




<?php
    require_once ROOT . '/views/include/footer.php';
?>
