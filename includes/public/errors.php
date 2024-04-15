<?php 
if (count($errors) > 0) :{ ?>
    <div>
        <?php foreach ($errors as $error) : ?>
            <p><span style="color: red;"><?php echo $error ?></span></p>
        <?php endforeach ?>
    </div>
<?php } endif ?>