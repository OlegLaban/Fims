</div>
<div class="row">
    <div class="col-4">
        <p>News</p>
        <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="col-4">
        <h2>Last add users:</h2>
        <div class="row tableLastAddUsers">
            <div class="col-4">
               <h3>Name</h3>
            </div>
            <div class="col-4">
                <h3>Company</h3>
            </div>
        </div>
         <?php foreach ($lastUsersArr as $item): ?>
            <div class="row tableLastAddUsers">
                <div class="col-4">
                    <?php echo $item['first_name'] ;?>
                </div>
                <div class="col-4"><?php echo $item['firm_name'] ;?></div>
            </div>
         <?php endforeach; ?>

    </div>
    <div class="col-4 subscribe">
        <h2>Subscribe</h2>
        <form action="">
            <input type="email" name="email" class="subscribeInput">
            <input type="button" class="subscribeInput" value="Subscribe" name="Subscribe">
        </form>
    </div>
</div>
<div class="row copy">
    <p> &copy; copyright 2019 </p>
</div>
</div>
</div>
</body>
</html>