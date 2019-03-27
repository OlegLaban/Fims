<?php require_once ROOT . '/include/header.php';?>
    <div class="row content">
    <div class="col-3">
        <img src="../img/banner.png" alt="">
    </div>
    <div class="col-9 blockContent">

        <div class="row rowContent">
            <?php foreach ($arr as $item): ?>
                <div class="col-4">
                    <div class="row">
                        <img src="../img/<?php echo $item['logo']; ?>" alt="" class="logoCompany">
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
<?php require_once ROOT . '/include/footer.php';?>