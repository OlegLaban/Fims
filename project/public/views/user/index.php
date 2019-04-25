<?php require_once ROOT . '/views/include/header.php';?>
    <div class="row content">
    <div class="col-3">
        <div class="filter">
            <h2 class="opis">Фильтр:</h2>
            <form action="/users/" method="get" class="filterForm">
                <p>Фамилии по алфавиту:</p>
                    <p>От: <input type="text" name="filter[literaOt]" pattern="[A-Za-zА-Яа-яЁё]"
                                  value="<?php if(isset($data['literaOt'])){ echo $data['literaOt']; } ?>">
                    </p>
                    <p>До: <input type="text" name="filter[literaDo]" pattern="[A-Za-zА-Яа-яЁё]"
                                  value="<?php if(isset($data['literaDo'])){ echo $data['literaDo']; } ?>">
                    </p>
                 <p class="opis">Company</p>
                <div class="radioCompanyFilter">
                    <?php foreach ($arrCompanyName as $item): ?>
                    <p><input type="checkbox" name="filter[company][]"
                              <?php if(isset($data['company'])){if(in_array($item['id_firm'], $data['company'])){ echo "checked='checked'"; }} ?>
                              value="<?php echo $item['id_firm']; ?>">
                        <?php echo $item['firm_name']; ?>
                    </p>
                    <?php endforeach;?>
                </div>
                <p class="opis">Date</p>
                <div class="date">
                    <p>От: <input type="date" name="filter[dateOt]"
                                  value="<?php if(isset($data['dateOt']) && $data['dateOt'] != ''){echo $data['dateOt'];} ?>">
                    </p>
                    <p>До: <input type="date" name="filter[dateDo]" value="<?php
                        if(isset($data['dateOt']) && $data['dateDo'] != ''){echo $data['dateDo'];} ?>">
                    </p>
                </div>
                <input type="submit" name="subFilter" value="Фильтруй">
                <input type="submit" name="unsetSub" value="Сброс">
            </form>
        </div>
    </div>
    <div class="col-9 blockContent">

        <div class="row rowContent">
            <div class="col-2 table">First name</div>
            <div class="col-2 table">Last name</div>
            <div class="col-2 table">Age</div>
            <div class="col-2 table">Company</div>
            <div class="col-2 table">Date</div>
            <div class="col-2 table"> </div>
        </div>
        <?php foreach ($arr as $item): ?>
            <div class="row rowContent">
                <div class="col-2 table"><?php echo $item['first_name']; ?></div>
                <div class="col-2 table"><?php echo $item['Last_name']; ?></div>
                <div class="col-2 table"><?php echo Other::getYear($item['birthd_day']);?></div>
                <div class="col-2 table"><?php echo $item['firm_name']; ?></div>
                <div class="col-2 table"><?php echo Other::getYear($item['date']); ?></div>
                <div class="col-2 table"><a>More...</a></div>
            </div>
        <?php endforeach; ?>
        <div class="row pagination">
            <?php
            echo $pagination->get();
            ?>
        </div>
    </div>
<?php require_once ROOT . '/views/include/footer.php';?>