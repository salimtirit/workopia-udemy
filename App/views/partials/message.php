<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="message bg-green-100 p-3 my-3">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline"><?= $_SESSION['success_message'] ?></span>
    </div>
    <?php unset($_SESSION['success_message']) ?>
<?php endif; ?>


<?php if (isset($_SESSION['error_message'])) : ?>
    <div class="message bg-red-100 p-3 my-3">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline"><?= $_SESSION['error_message'] ?></span>
    </div>
    <?php unset($_SESSION['error_message']) ?>
<?php endif; ?>