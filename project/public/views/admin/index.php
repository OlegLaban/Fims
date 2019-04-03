<?php require_once ROOT . '/include/header.php'; ?>


<div class="row content">
    <div class="col-9 blockContent">

        <div class="row rowContent">
            <div class="row">
                <div class="col-3">Logo</div>
                <div class="col-3">Firm name</div>
                <div class="col-3">col workers</div>
                <div class="col-3">View more</div>
            </div>
            <?php foreach ($arr as $item): ?>
               <div class='row'>
                   <div class="col-3">
                       <img src="<?php echo $item['logo']; ?>" alt="<?php echo $item['firm_name']; ?>">
                   </div>
                   <div class="col-3"><?php echo $item['firm_name']; ?></div>
                   <div class="col-3"><?php echo $item['col_workers']; ?></div>
                   <div class="col-3"><a href="/admin/redCompany/"><?php echo $item['id_firm']; ?></a></div
               </div>
            <?php endforeach; ?>
        </div>
        <div class="row pagination">
            <?php
            echo $pagination->get();
            ?>
        </div>
    </div>




<?php require_once ROOT . '/include/footer.php'; ?>