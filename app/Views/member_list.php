<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pradesh Mavasi Thakur Vikas Samiti</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/public/icons/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/public/icons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/public/icons/favicon.svg" />
    <link rel="shortcut icon" href="/public/icons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/public/icons/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Pradesh Mavasi Thakur Vikas Samiti" />
    <link rel="manifest" href="/site.webmanifest" />
    <!-- STYLES -->


</head>

<body class="bg-light">
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="<?= base_url('/icons/favicon.svg') ?>" alt="Logo" width="40" height="40" class="me-2">
                <span class="fw-bold">प्रदेश मवासी ठाकुर विकास समिति</span>
            </a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">सदास्यो की सुची</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($members)): ?>
                <?php foreach ($members as $member): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <?php if ($member['image']): ?>
                                <img src="<?= base_url('uploads/' . $member['image']) ?>" class="card-img-top"
                                    alt="<?= esc($member['name']) ?>" style="height:200px;object-fit:cover;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/200x200?text=No+Image" class="card-img-top" alt="No Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($member['name']) ?></h5>
                                <p class="card-text mb-1"><strong>Position:</strong> <?= esc($member['position']) ?></p>
                                <p class="card-text"><strong>Address:</strong> <?= esc($member['address']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <div class="alert alert-info text-center">No members found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>