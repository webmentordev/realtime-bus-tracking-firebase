<?php if(count($errors) > 0): ?>
    <ul class="bg-red-500 text-white text-center p-2">
        <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>