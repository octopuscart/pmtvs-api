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
                        <form id="memberForm" enctype="multipart/form-data" method="post" action="<?= site_url('api/create-member') ?>">
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
                            <div class="mb-3">
                                <label class="form-label">Image:</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                        <div id="uploadedImage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('memberForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        const response = await fetch("http://127.0.0.1/pmtvs/api/create-member", {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        const resultDiv = document.getElementById('result');
        const imageDiv = document.getElementById('uploadedImage');
        resultDiv.textContent = '';
        imageDiv.innerHTML = '';

        if (result.success) {
            resultDiv.className = "alert alert-success";
            resultDiv.textContent = 'Member created successfully!';
            if (result.data && result.data.image) {
                imageDiv.innerHTML = `<p>Uploaded Image:</p><img src="/uploads/${result.data.image}" class="img-thumbnail" width="200">`;
            }
        } else {
            resultDiv.className = "alert alert-danger";
            if (result.messages) {
                // Validation errors from CodeIgniter
                let errors = [];
                for (const key in result.messages) {
                    errors.push(`${key}: ${result.messages[key]}`);
                }
                resultDiv.textContent = errors.join('\n');
            } else if (result.data) {
                // Validation errors from ResourceController
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