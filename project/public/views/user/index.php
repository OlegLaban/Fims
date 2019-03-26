<?php require_once ROOT . '/include/header.php';?>
    <div class="row content">
    <div class="col-3">
        <img src="../img/banner.png" alt="">
    </div>
    <div class="col-9 blockContent">

        <div class="row rowContent">
            <div class="col-2 table">First name</div>
            <div class="col-2 table">Last name</div>
            <div class="col-2 table">Age</div>
            <div class="col-2 table">Company</div>
            <div class="col-2 table"> </div>
        </div>
        <?php foreach ($arr as $item): ?>
            <div class="row rowContent">
                <div class="col-2 table"><?php echo $item['first_name']; ?></div>
                <div class="col-2 table"><?php echo $item['Last_name']; ?></div>
                <div class="col-2 table"><?php echo Other::getAge($item['birthd_day']);?></div>
                <div class="col-2 table"><?php echo $item['firm_name']; ?></div>
                <div class="col-2 table"><a>More...</a></div>
            </div>
        <?php endforeach; ?>
        <div class="row pagination">
            <?php
            echo $pagination->get();
            ?>
        </div>
    </div>
<?php require_once ROOT . '/include/footer.php';?>