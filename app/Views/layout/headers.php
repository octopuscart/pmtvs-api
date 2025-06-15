<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pradesh Mavasi Thakur Vikas Samiti</title>
    <meta name="description"
        content="प्रदेश मवासी ठाकुर विकास समिति (Pradesh Mavasi Thakur Vikas Samiti) is a community organization dedicated to the welfare, unity, and development of the Thakur community. View member directory, activities, and updates.">
    <meta name="keywords"
        content="Thakur Samiti, Pradesh Mavasi, Thakur Vikas Samiti, Community, Member Directory, Social Organization, Thakur Welfare, Thakur Community, विकास समिति, समाज, सदस्य सूची">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/public/icons/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/public/icons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/public/icons/favicon.svg" />
    <link rel="shortcut icon" href="/public/icons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/public/icons/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Pradesh Mavasi Thakur Vikas Samiti" />
    <link rel="manifest" href="/site.webmanifest" />
</head>

<body class="bg-light">
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="<?= base_url('/icons/favicon.svg') ?>" alt="Logo" width="40" height="40" class="me-2">
                <span class="fw-bold">प्रदेश मवासी ठाकुर विकास समिति</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('/') ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('create-member') ?>">Create Member</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="positionDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Position
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="positionDropdown">
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= site_url('position-categories?type=positions') ?>">Position Management</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('position-categories') ?>">Position Category
                                        Management</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('list-post') ?>">Post List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('create-post') ?>">Create post</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('logout') ?>">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('login') ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>