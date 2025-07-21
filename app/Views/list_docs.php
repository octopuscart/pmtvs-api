<?= $this->include('layout/headers') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Uploaded Documents</h4>
                <a href="<?= site_url('upload-bill-doc') ?>" class="btn btn-success">Add Document</a>
            </div>
            <div id="docsList" class="row row-cols-1 row-cols-md-4 g-4"></div>
        </div>
    </div>
</div>

<script>
async function fetchDocs() {
    const res = await fetch('<?= site_url('api/list-documents') ?>');
    const data = await res.json();
    const docsList = document.getElementById('docsList');
    docsList.innerHTML = '';
    if (!data.success || !data.documents.length) {
        docsList.innerHTML = '<div class="col"><div class="alert alert-info text-center">No documents found.</div></div>';
        return;
    }
    data.documents.forEach(doc => {
        let preview = '';
        if (doc.type.startsWith('image/')) {
            preview = `<img src="${doc.url}" class="img-fluid mb-2" style="max-height:150px;object-fit:contain;" alt="Image">`;
        } else if (doc.type === 'application/pdf') {
            preview = `<span class="badge bg-danger">PDF</span>`;
        }
        docsList.innerHTML += `
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        ${preview}
                        <p class="card-text small mt-2">${doc.filename}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="${doc.url}" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
        `;
    });
}
fetchDocs();
</script>

<?= $this->include('layout/footer') ?> 