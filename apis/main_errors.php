<?php if(count($errors) > 0): ?>
    <ul class="error" id="error">
        <?php foreach($errors as $error): ?>
            <li><i class="fas fa-burn"></i><?php echo $error; ?></li>
        <?php endforeach ?>
    </ul>
    <button onclick="showError()" id="errorbtn1"><i class="fas fa-caret-left"></i></button>
    <button onclick="closeError()" id="errorbtn2"><i class="fas fa-caret-right"></i></button>
<?php endif ?>