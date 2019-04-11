<?php require_once ROOT . '/views/include/header.php'; ?>
    <h2>Admin/Companies</h2>
    <div class="row content">
    <div class="col-3">
        <div class="filter">
            <h2 class="opis">Фильтр:</h2>
            <form action="/admin/" method="POST">
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
                <div class="col-2 table">Logo</div>
                <div class="col-2 table">Firm name</div>
                <div class="col-2 table">col workers</div>
                <div class="col-2 table">View more</div>
                <div class="col-2 table"></div>
        </div>
        <?php foreach ($arr as $item): ?>
            <div class="row rowContent">
                <div class="col-2 table">
                    <img src="<?php echo $item['logo']; ?>" class="imgUser" alt="<?php echo $item['firm_name']; ?>">
                </div>
                <div class="col-2 table"><?php echo $item['firm_name']; ?></div>
                <div class="col-2 table"><?php echo $item['col_workers']; ?></div>
                <div class="col-2 table"><a href="/admin/redCompany/<?php echo $item['id_firm']; ?>">view</a></div>
                <div class="col-2 table"><a href="/admin/delCompany/<?php echo $item['id_firm']; ?>">Delete</a></div>
            </div>
        <?php endforeach; ?>
        <div class="row pagination">
            <?php
            echo $pagination->get();
            ?>
        </div>
    </div>




<?php require_once ROOT . '/views/include/footer.php'; ?>