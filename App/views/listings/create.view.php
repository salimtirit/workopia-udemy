<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>
<?= loadPartial('top-banner') ?>

<!-- Post a Job Form Box -->
<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Create Job Listing</h2>
        <form method="POST" action="/listings">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>
            <?php if (isset($errors)) : ?>
                <div class="message bg-red-100 p-3 my-3">
                    <?php foreach ($errors as $error) : ?>
                        <div><?= $error ?></div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Job Title</label>
                <input type="text" name="title" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['title'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Job Description</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded focus:outline-none"><?= $listing['description'] ?? '' ?></textarea>
            </div>
            <div class="mb-4">
                <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">Annual Salary</label>
                <input type="text" name="salary" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['salary'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="requirements" class="block text-gray-700 text-sm font-bold mb-2">Requirements</label>
                <input type="text" name="requirements" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['requirements'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="benefits" class="block text-gray-700 text-sm font-bold mb-2">Benefits</label>
                <input type="text" name="benefits" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['benefits'] ?? '' ?>" />
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info & Location
            </h2>
            <div class="mb-4">
                <label for="company" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                <input type="text" name="company" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['company'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <input type="text" name="address" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['address'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City</label>
                <input type="text" name="city" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['city'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700 text-sm font-bold mb-2">State</label>
                <input type="text" name="state" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['state'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input type="text" name="phone" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['phone'] ?? '' ?>" />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address For Applications</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $listing['email'] ?? '' ?>" />
            </div>
            <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Save
            </button>
            <a href="/" class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
                Cancel
            </a>
        </form>
    </div>
</section>


<?= loadPartial('bottom-banner') ?>
<?= loadPartial('footer') ?>