<?= $this->include('layout/headers') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><?= isset($member) ? 'Update' : 'Create' ?> Member</h4>
                </div>
                <div class="card-body">
                    <!-- Image Upload Form -->
                    <form id="imageUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Image:</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*"
                                <?= isset($member) && $member['image'] ? '' : 'required' ?>>
                        </div>
                        <button type="submit" class="btn btn-secondary mb-3">Upload Image</button>
                    </form>
                    <div id="imageUploadResult" class="mb-3"></div>
                    <div id="uploadedImage" class="mb-3">
                        <?php if (isset($member) && $member['image']): ?>
                            <img src="<?= base_url('uploads/' . $member['image']) ?>" class="img-thumbnail" width="200">
                        <?php endif; ?>
                    </div>
                    <!-- Member Form -->
                    <form id="memberForm" method="post" action="<?= site_url('api/create-member') ?>">
                        <?php if (isset($member)): ?>
                            <input type="hidden" name="id" value="<?= esc($member['id']) ?>">
                        <?php endif; ?>
                        <input type="hidden" name="image" id="hiddenImageField"
                            value="<?= isset($member) ? esc($member['image']) : '' ?>">
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control"
                                value="<?= isset($member) ? esc($member['name']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position Category:</label>
                            <select name="position_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= (isset($member) && $member['position_category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= esc($cat['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position:</label>
                            <select name="position_id" class="form-control" required>
                                <option value="">Select Position</option>
                                <?php foreach ($positions as $pos): ?>
                                    <option value="<?= $pos['id'] ?>" <?= (isset($member) && $member['position_id'] == $pos['id']) ? 'selected' : '' ?>>
                                        <?= esc($pos['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <input type="text" name="address" class="form-control"
                                value="<?= isset($member) ? esc($member['address']) : '' ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><?= isset($member) ? 'Update' : 'Create' ?>
                            Member</button>
                    </form>
                    <div id="result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Utility to enable/disable member form fields
    function setMemberFormEnabled(enabled) {
        const form = document.getElementById('memberForm');
        Array.from(form.elements).forEach(el => {
            if (el.name !== 'image' && el.type !== 'hidden') {
                el.disabled = !enabled;
            }
        });
    }

    // On page load, disable fields if no image is present
    window.addEventListener('DOMContentLoaded', function () {
        const hasImage = document.getElementById('hiddenImageField').value !== '';
        setMemberFormEnabled(hasImage);
    });

    // Handle image upload
    document.getElementById('imageUploadForm').onsubmit = async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        data.append('type', 'post');
        const resultDiv = document.getElementById('imageUploadResult');
        const imageDiv = document.getElementById('uploadedImage');
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
            imageDiv.innerHTML = `<p>Uploaded Image:</p><img src="<?= base_url('uploads/'); ?>${result.image}" class="img-thumbnail" width="200">`;
            document.getElementById('hiddenImageField').value = result.image;
             setMemberFormEnabled(true); // Enable fields after image upload
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
                        setMemberFormEnabled(false); // Keep fields disabled if upload fails

        }
    };

    // Handle member create/update
    document.getElementById('memberForm').onsubmit = async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        const resultDiv = document.getElementById('result');
        resultDiv.textContent = '';

        if (!document.getElementById('hiddenImageField').value) {
            resultDiv.className = "alert alert-danger";
            resultDiv.textContent = "Please upload an image first.";
            return;
        }

        const response = await fetch("<?= site_url('api/create-member') ?>", {
            method: 'POST',
            body: data
        });
        const result = await response.json();

        if (result.success) {
            resultDiv.className = "alert alert-success";
            resultDiv.textContent = 'Member <?= isset($member) ? "updated" : "created" ?> successfully! Redirecting...';
            setTimeout(() => {
                window.location.href = "<?= site_url('create-member') ?>";
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