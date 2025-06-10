<?= $this->include('layout/headers') ?>

<?php
// $post should be passed from the controller
$isUpdate = isset($post) && !empty($post['id']);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><?= $isUpdate ? 'Update' : 'Create' ?> Daily Post</h4>
                </div>
                <div class="card-body">
                    <!-- Image Upload Form -->
                    <form id="postImageUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Image:</label>
                            <input type="file" name="image" id="postImageInput" class="form-control" accept="image/*" <?= $isUpdate ? '' : 'required' ?>>
                        </div>
                        <button type="submit" class="btn btn-secondary mb-3">Upload Image</button>
                    </form>
                    <div id="postImageUploadResult" class="mb-3"></div>
                    <div id="uploadedPostImage" class="mb-3">
                        <?php if ($isUpdate && !empty($post['image'])): ?>
                            <p>Current Image:</p>
                            <img src="<?= base_url('post_uploads/' . $post['image']) ?>" class="img-thumbnail" width="200">
                        <?php endif; ?>
                    </div>
                    <!-- Post Form -->
                    <form id="dailyPostForm" method="post" action="<?= site_url('api/create-daily-post') ?>">
                        <?php if ($isUpdate): ?>
                            <input type="hidden" name="id" value="<?= esc($post['id']) ?>">
                        <?php endif; ?>
                        <input type="hidden" name="image" id="hiddenPostImageField" value="<?= esc($post['image'] ?? '') ?>">
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <textarea name="description" class="form-control" required><?= esc($post['description'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date:</label>
                            <input type="date" name="date" class="form-control" required value="<?= esc($post['date'] ?? date('Y-m-d')) ?>">
                        </div>
                        <button type="submit" class="btn btn-success w-100"><?= $isUpdate ? 'Update' : 'Create' ?> Post</button>
                    </form>
                    <div id="postResult" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Enable/disable post form fields
    function setPostFormEnabled(enabled) {
        const form = document.getElementById('dailyPostForm');
        Array.from(form.elements).forEach(el => {
            if (el.name !== 'image' && el.type !== 'hidden') {
                el.disabled = !enabled;
            }
        });
    }

    // On page load, enable if image exists (for update), else disable
    window.addEventListener('DOMContentLoaded', function () {
        setPostFormEnabled(!!document.getElementById('hiddenPostImageField').value);
    });

    // Handle post image upload
    document.getElementById('postImageUploadForm').onsubmit = async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        data.append('type', 'post');
        const resultDiv = document.getElementById('postImageUploadResult');
        const imageDiv = document.getElementById('uploadedPostImage');
        resultDiv.textContent = '';
        imageDiv.innerHTML = '';

        const response = await fetch("<?= site_url('api/upload-image') ?>", {
            method: 'POST',
            body: data
        });
        const result = await response.json();

        if (result.success) {
            resultDiv.className = "alert alert-success";
            resultDiv.textContent = 'Image uploaded successfully!';
            imageDiv.innerHTML = `<p>Uploaded Image:</p><img src="<?= base_url('post_uploads/'); ?>${result.image}" class="img-thumbnail" width="200">`;
            document.getElementById('hiddenPostImageField').value = result.image;
            setPostFormEnabled(true);
        } else {
            resultDiv.className = "alert alert-danger";
            if (result.messages) {
                let errors = [];
                for (const key in result.messages) {
                    errors.push(`${key}: ${result.messages[key]}`);
                }
                resultDiv.textContent = errors.join('\n');
            } else if (result.error) {
                resultDiv.textContent = result.error;
            } else {
                resultDiv.textContent = 'An error occurred.';
            }
            setPostFormEnabled(false);
        }
    };

    // Handle daily post create/update
    document.getElementById('dailyPostForm').onsubmit = async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        const resultDiv = document.getElementById('postResult');
        resultDiv.textContent = '';

        if (!document.getElementById('hiddenPostImageField').value) {
            resultDiv.className = "alert alert-danger";
            resultDiv.textContent = "Please upload an image first.";
            return;
        }

        const response = await fetch("<?= site_url('api/create-daily-post') ?>", {
            method: 'POST',
            body: data
        });
        const result = await response.json();

        if (result.success) {
            resultDiv.className = "alert alert-success";
            resultDiv.textContent = 'Post <?= $isUpdate ? "updated" : "created" ?> successfully!';
            setTimeout(() => {
                window.location.href = "<?= site_url('list-post') ?>";
            }, 1500);
        } else {
            resultDiv.className = "alert alert-danger";
            if (result.messages) {
                let errors = [];
                for (const key in result.messages) {
                    errors.push(`${key}: ${result.messages[key]}`);
                }
                resultDiv.textContent = errors.join('\n');
            } else if (result.data) {
                let errors = [];
                for (const key in result.data) {
                    errors.push(`${key}: ${result.data[key]}`);
                }
                resultDiv.textContent = errors.join('\n');
            } else if (result.error) {
                resultDiv.textContent = result.error;
            } else {
                resultDiv.textContent = 'An error occurred.';
            }
        }
    };
</script>

<?= $this->include('layout/footer') ?>