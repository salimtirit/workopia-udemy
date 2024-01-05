<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>

<section>
    <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3"><?= $status ?></div>
        <p class="text-center text-2xl mb-4">
            <?= $message ?>
        </p>
        <a href="/listings" class="block text-xl text-center">
            <i class="fa fa-arrow-alt-circle-left"></i>
            Back To Listings
    </div>
</section>

<?= loadPartial('footer') ?>