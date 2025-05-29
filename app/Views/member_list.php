<?= $this->include('layout/headers') ?>

<div class="container mt-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0" style="font-size:1.1rem;">Categories</h5>
                </div>
                <ul class="list-group list-group-flush" id="categoryList">
                    <li class="list-group-item active" data-id="0">All Members</li>
                </ul>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9">
            <h2 class="mb-4 text-center">सदास्यो की सुची</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4" id="membersList">
                <div class="col">
                    <div class="alert alert-info text-center">Loading members...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function fetchCategories() {
        const res = await fetch('<?= site_url('api/position-categories') ?>');
        const data = await res.json();
        if (data.success && data.categories) {
            const list = document.getElementById('categoryList');
            data.categories.forEach(cat => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = cat.title;
                li.dataset.id = cat.id;
                li.onclick = () => selectCategory(cat.id, li);
                list.appendChild(li);
            });
        }
    }

    async function fetchMembers(categoryId = '1') {
        const url = categoryId
            ? '<?= site_url('api/members') ?>/' + categoryId
            : '<?= site_url('api/members/0') ?>';
        const membersList = document.getElementById('membersList');
        membersList.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="min-height:200px;width:100%;">
                <div class="alert alert-info text-center mb-0">Loading members...</div>
            </div>
        `;
        const res = await fetch(url);
        const data = await res.json();

        if (data.success && data.members && data.members.length) {
            membersList.innerHTML = ''; // Clear loading message
            data.members.forEach(member => {
                const col = document.createElement('div');
                col.className = 'col';
                col.innerHTML = `
                <div class="card h-100 shadow-sm">
                    ${member.image_url ? `<img src="${member.image_url}" class="card-img-top" alt="${member.name}" style="height:200px;object-fit:contain;">` : `<img src="https://via.placeholder.com/200x200?text=No+Image" class="card-img-top" alt="No Image">`}
                    <div class="card-body">
                        <h5 class="card-title">${member.name}</h5>
                        <p class="card-text mb-1"><strong>${member.position_title ?? ''}</strong></p>
                        <p class="card-text mb-1">${member.category_title ?? ''}</p>
                        <p class="card-text"><strong>Address:</strong> ${member.address}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?= site_url('update-member/') ?>${member.id}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            `;
                membersList.appendChild(col);
            });
        } else {
            membersList.innerHTML = `<div class="col"><div class="alert alert-info text-center">No members found.</div></div>`;
        }
    }

    function selectCategory(id, li) {
        document.querySelectorAll('#categoryList .list-group-item').forEach(el => el.classList.remove('active'));
        li.classList.add('active');
        fetchMembers(id);
    }

    // Initial load
    fetchCategories();
    fetchMembers();
    document.querySelector('#categoryList').onclick = function (e) {
        if (e.target && e.target.matches('li[data-id]')) {
            selectCategory(e.target.dataset.id, e.target);
        }
    };
</script>

<?= $this->include('layout/footer') ?>