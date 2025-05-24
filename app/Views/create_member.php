<!DOCTYPE html>
<html>

<head>
    <title>Create Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create Member</h4>
                    </div>
                    <div class="card-body">
                        <!-- Image Upload Form -->
                        <form id="imageUploadForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Image:</label>
                                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-secondary mb-3">Upload Image</button>
                        </form>
                        <div id="imageUploadResult" class="mb-3"></div>
                        <div id="uploadedImage" class="mb-3"></div>
                        <!-- Member Creation Form -->
                        <form id="memberForm" method="post" action="<?= site_url('api/create-member') ?>">
                            <input type="hidden" name="image" id="hiddenImageField">
                            <div class="mb-3">
                                <label class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Position:</label>
                                <input type="text" name="position" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address:</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Handle image upload
        document.getElementById('imageUploadForm').onsubmit = async function (e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const resultDiv = document.getElementById('imageUploadResult');
            const imageDiv = document.getElementById('uploadedImage');
            resultDiv.textContent = '';
            imageDiv.innerHTML = '';
            document.getElementById('hiddenImageField').value = '';

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
            }
        };

        // Handle member creation
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
                resultDiv.textContent = 'Member created successfully! Refreshing...';
                setTimeout(() => {
                    window.location.reload();
                }, 1500); // Refresh after 1.5 seconds
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
</body>

</html>