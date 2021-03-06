<?php require_once ROOT . '/views/include/header.php';?>
    <div class="row content">
    <div class="col-3">
        <img src="/assets/img/banner.png" alt="">
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
    </div>
<?php require_once ROOT . '/views/include/footer.php';?>