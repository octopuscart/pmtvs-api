<?= $this->include('layout/headers') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3 text-end">
                <a href="<?= site_url('list-docs') ?>" class="btn btn-outline-secondary">View All Documents</a>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Upload Bill/Document (PDF or Image)</h5>
                </div>
                <div class="card-body">
                    <form id="uploadForm">
                        <div class="mb-3">
                            <label for="file" class="form-label">Select PDF or Image</label>
                            <input class="form-control" type="file" id="file" name="file" accept=".pdf,image/*" required>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                    <div id="uploadResult" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('uploadForm').onsubmit = async function(e) {
    e.preventDefault();
    const form = e.target;
    const fileInput = form.file;
    const resultDiv = document.getElementById('uploadResult');
    resultDiv.innerHTML = '';
    if (!fileInput.files.length) {
        resultDiv.innerHTML = '<div class="alert alert-warning">Please select a file.</div>';
        return;
    }
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);
    try {
        const res = await fetch('<?= site_url('api/upload-bill-doc') ?>', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        if (data.success) {
            let preview = '';
            if (data.type.startsWith('image/')) {
                preview = `<img src="${data.url}" alt="Preview" class="img-fluid mt-2" style="max-height:200px;">`;
            } else if (data.type === 'application/pdf') {
                preview = `<a href="${data.url}" target="_blank" class="btn btn-outline-primary mt-2">View PDF</a>`;
            }
            resultDiv.innerHTML = `<div class="alert alert-success">Upload successful!</div>${preview}`;
        } else {
            resultDiv.innerHTML = `<div class="alert alert-danger">${data.message || 'Upload failed.'}</div>`;
        }
    } catch (err) {
        resultDiv.innerHTML = '<div class="alert alert-danger">Error uploading file.</div>';
    }
};
</script>

<?= $this->include('layout/footer') ?> 