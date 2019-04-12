<?php require_once ROOT . '/views/include/header.php';?>
    <div class="row content">
    <div class="col-3">
        <div class="filter">
            <h2 class="opis">Фильтр:</h2>
            <form action="/companies/" method="GET">
                <p>Название по алфавиту:</p>
                <p>От: <input type="text" name="filterFirm[literaOt]" pattern="[A-Za-zА-Яа-яЁё]"
                              value="<?php echo $filterCompany['literaOt']; ?>">
                </p>
                <p>До: <input type="text" name="filterFirm[literaDo]" pattern="[A-Za-zА-Яа-яЁё]"
                              value="<?php echo $filterCompany['literaDo']; ?>">
                </p>
                <p class="opis">Колличество сотрудников</p>
                <div class="count">
                    <p>От: <input type="range" min="0" max="100" id="chisloOt" name="filterFirm[chisloOt]" pattern="[A-Za-zА-Яа-яЁё]"
                                  value="<?php echo $filterCompany['chisloOt'];?>">
                        <span id="outputOt"><?php echo $filterCompany['chisloOt'];?></span>/100
                    </p>
                    <p>До: <input type="range" min="0" max="100" id="chisloDo" name="filterFirm[chisloDo]" pattern="[A-Za-zА-Яа-яЁё]"
                                  value="<?php echo $filterCompany['chisloDo'];?>">
                        <span id="outputDo"><?php echo $filterCompany['chisloDo'];?></span>/100
                    </p>
                </div>
                <input type="submit" name="subFilterFirm" value="Отправить">
                <input type="submit" name="resetFilterFirm" value="Сброс">
            </form>
        </div>
    </div>
    <div class="col-9 blockContent">

        <div class="row rowContent">
            <?php foreach ($arr as $item): ?>
                <div class="col-4">
                    <div class="row">
                        <img src="/assets/img/<?php echo $item['logo']; ?>" alt="" class="logoCompany">
                        <h2><?php echo $item['firm_name']; ?></h2>
                    </div>
                    <p>
                        <?php echo $item['description']; ?>
                        <button>View more</button>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row pagination">
            <?php
                echo $pagination->get();
            ?>
        </div>
    </div>
<?php require_once ROOT . '/views/include/footer.php';?>