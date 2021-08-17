<?php if(count($errors) > 0): ?>
    <ul class="error" style="margin: 5px 0px">
        <?php foreach($errors as $error): ?>
            <li><i class="fas fa-fire status" style="color: white; font-size: 14px;"></i><?php echo $error; ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>