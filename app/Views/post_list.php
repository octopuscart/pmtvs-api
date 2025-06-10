<?= $this->include('layout/headers') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">Daily Posts</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4" id="postsList">
                <div class="col">
                    <div class="alert alert-info text-center">Loading posts...</div>
                </div>
            </div>
            <nav>
                <ul class="pagination justify-content-center mt-4" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    let totalPages = 1;

    async function fetchPosts(page = 1) {
        const postsList = document.getElementById('postsList');
        postsList.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="min-height:200px;width:100%;">
                <div class="alert alert-info text-center mb-0">Loading posts...</div>
            </div>
        `;
        const res = await fetch('<?= site_url('api/list-daily-posts') ?>?page=' + page);
        const data = await res.json();

        if (data.success && data.posts && data.posts.length) {
            postsList.innerHTML = '';
            data.posts.forEach(post => {
                const col = document.createElement('div');
                col.className = 'col';
                col.innerHTML = `
                <div class="card h-100 shadow-sm">
                    ${post.image_url ? `<img src="${post.image_url}" class="card-img-top" alt="Post Image" style="height:200px;object-fit:contain;">` : `<img src="https://via.placeholder.com/200x200?text=No+Image" class="card-img-top" alt="No Image">`}
                    <div class="card-body">
                        <h5 class="card-title">${post.description}</h5>
                        <p class="card-text"><strong>Date:</strong> ${post.date}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= site_url('update-post/') ?>${post.id}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
                `;
                postsList.appendChild(col);
            });
            renderPagination(data.pagination.page, data.pagination.total_pages);
        } else {
            postsList.innerHTML = `<div class="col"><div class="alert alert-info text-center">No posts found.</div></div>`;
            renderPagination(1, 1);
        }
    }

    function renderPagination(page, total) {
        currentPage = page;
        totalPages = total;
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item' + (i === currentPage ? ' active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.onclick = function(e) {
                e.preventDefault();
                if (i !== currentPage) fetchPosts(i);
            };
            pagination.appendChild(li);
        }
    }

    // Initial load
    fetchPosts();
</script>

<?= $this->include('layout/footer') ?>