<?php require_once ROOT . '/include/header.php'; ?>



<div class="row content">
       <div class="col-9 AdminBlockContent">
           <form action="" method="post" enctype="multipart/form-data">
               <span class="textForm">Название фирмы:</span>
               <input type="text" name="firm_name">
               <span class="textForm">ОГРН:</span>
               <input type="number" name="ogrn">
               <span class="textForm">ОКТМО:</span>
               <input type="number" name="oktmo">
               <span class="textForm">Описание фирмы:</span>
               <input type="text" name="description">
               <span class="textForm">Логотип:</span>
               <input type="file" id="logoCompany"  data-src="<?php echo $src; ?>">
               <input type="hidden" id="logo" name="logo" value="">
               <img src=""  alt="logoCompany" id="imgFile">
               <input type="submit" name="subAddCompany">
           </form>
       </div>
    <div id="debug">

    </div>



<?php require_once ROOT . '/include/footer.php'; ?>
