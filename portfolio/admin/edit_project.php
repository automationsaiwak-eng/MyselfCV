<?php
/**
 * admin/edit_project.php – Edit existing project
 */

session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$db = getDB();
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: dashboard.php');
    exit;
}

// Fetch project
$stmt = $db->prepare('SELECT * FROM projects WHERE id = ?');
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title        = trim(strip_tags($_POST['title']        ?? ''));
    $description  = trim(strip_tags($_POST['description']  ?? ''));
    $technologies = trim(strip_tags($_POST['technologies'] ?? ''));
    $github_link  = trim(strip_tags($_POST['github_link']  ?? ''));
    $demo_link    = trim(strip_tags($_POST['demo_link']    ?? ''));

    if (!$title || !$description || !$technologies) {
        $error = 'Title, Description, and Technologies are required.';
    } else {
        $imageName = $project['image']; // Keep existing image by default

        // Handle new image upload
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['jpg','jpeg','png','gif','webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                $error = 'Only JPG, PNG, GIF, and WEBP images are allowed.';
            } elseif ($_FILES['image']['size'] > 3 * 1024 * 1024) {
                $error = 'Image size must be under 3MB.';
            } else {
                $newImageName = 'project_' . time() . '_' . uniqid() . '.' . $ext;
                $dest = '../assets/images/' . $newImageName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                    // Delete old image
                    if ($imageName && file_exists('../assets/images/' . $imageName)) {
                        @unlink('../assets/images/' . $imageName);
                    }
                    $imageName = $newImageName;
                } else {
                    $error = 'Failed to upload image. Check folder permissions.';
                }
            }
        }

        // Remove image flag
        if (isset($_POST['remove_image']) && $_POST['remove_image'] === '1') {
            if ($imageName && file_exists('../assets/images/' . $imageName)) {
                @unlink('../assets/images/' . $imageName);
            }
            $imageName = null;
        }

        if (!$error) {
            try {
                $stmt = $db->prepare(
                    'UPDATE projects SET title=?, description=?, technologies=?, image=?, github_link=?, demo_link=? WHERE id=?'
                );
                $stmt->execute([$title, $description, $technologies, $imageName, $github_link ?: null, $demo_link ?: null, $id]);
                $success = 'Project updated successfully!';
                // Re-fetch
                $stmt2 = $db->prepare('SELECT * FROM projects WHERE id = ?');
                $stmt2->execute([$id]);
                $project = $stmt2->fetch();
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | Admin – Saiwak Ram</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <span style="background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:800;">SR<span class="brand-text" style="-webkit-text-fill-color:var(--text-primary);font-size:.85rem;font-weight:500;margin-left:8px;">Admin</span></span>
    </div>
    <nav>
        <a href="dashboard.php" class="sidebar-nav-item">
            <i class="bi bi-grid"></i><span class="nav-text">Dashboard</span>
        </a>
        <a href="add_project.php" class="sidebar-nav-item">
            <i class="bi bi-plus-circle"></i><span class="nav-text">Add Project</span>
        </a>
        <a href="../index.php" class="sidebar-nav-item" target="_blank">
            <i class="bi bi-eye"></i><span class="nav-text">View Portfolio</span>
        </a>
        <a href="logout.php" class="sidebar-nav-item">
            <i class="bi bi-box-arrow-right"></i><span class="nav-text">Logout</span>
        </a>
    </nav>
</aside>

<!-- Main -->
<div class="admin-main">
    <div class="admin-topbar">
        <h1 style="font-size:1.1rem;font-weight:700;margin:0;">
            Edit Project: <?= htmlspecialchars($project['title']) ?>
        </h1>
        <a href="dashboard.php" class="btn-outline-custom" style="padding:8px 18px;font-size:.85rem;">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="admin-content">
        <?php if ($error) : ?>
        <div class="alert" style="background:rgba(255,101,132,.15);border:1px solid rgba(255,101,132,.3);color:var(--accent-2);border-radius:10px;padding:12px 18px;margin-bottom:20px;" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <?php if ($success) : ?>
        <div class="alert" style="background:rgba(67,233,123,.15);border:1px solid rgba(67,233,123,.3);color:#43e97b;border-radius:10px;padding:12px 18px;margin-bottom:20px;" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <div class="admin-form-card">
            <form method="POST" action="edit_project.php?id=<?= $id ?>" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label class="form-label-custom" for="title">Project Title *</label>
                    <input type="text" id="title" name="title" class="form-control-custom"
                           placeholder="e.g. Transport ERP" required maxlength="150"
                           value="<?= htmlspecialchars($project['title']) ?>">
                </div>

                <div class="form-group mt-3">
                    <label class="form-label-custom" for="description">Description *</label>
                    <textarea id="description" name="description" class="form-control-custom" rows="4"
                              placeholder="Describe your project…" required><?= htmlspecialchars($project['description']) ?></textarea>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label-custom" for="technologies">Technologies Used *</label>
                    <input type="text" id="technologies" name="technologies" class="form-control-custom"
                           placeholder="e.g. PHP, MySQL, Bootstrap 5"
                           required maxlength="255"
                           value="<?= htmlspecialchars($project['technologies']) ?>">
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-sm-6 form-group">
                        <label class="form-label-custom" for="github_link">GitHub Link</label>
                        <input type="url" id="github_link" name="github_link" class="form-control-custom"
                               placeholder="https://github.com/…"
                               value="<?= htmlspecialchars($project['github_link'] ?? '') ?>">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="form-label-custom" for="demo_link">Live Demo Link</label>
                        <input type="url" id="demo_link" name="demo_link" class="form-control-custom"
                               placeholder="https://your-demo.com"
                               value="<?= htmlspecialchars($project['demo_link'] ?? '') ?>">
                    </div>
                </div>

                <!-- Current Image -->
                <?php if ($project['image'] && file_exists('../assets/images/' . $project['image'])) : ?>
                <div class="form-group mt-3">
                    <label class="form-label-custom">Current Image</label>
                    <div class="d-flex align-items-center gap-3">
                        <img src="../assets/images/<?= htmlspecialchars($project['image']) ?>"
                             alt="Current project image"
                             style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:1px solid var(--glass-border);">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.88rem;color:var(--accent-2);">
                            <input type="checkbox" name="remove_image" value="1"> Remove current image
                        </label>
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-group mt-3">
                    <label class="form-label-custom" for="image">
                        <?= $project['image'] ? 'Replace Image' : 'Upload Image' ?>
                    </label>
                    <input type="file" id="image" name="image" class="form-control-custom"
                           accept="image/jpeg,image/png,image/gif,image/webp" style="padding:10px 18px;">
                    <small style="color:var(--text-secondary);font-size:.8rem;">JPG, PNG, GIF, WEBP – Max 3MB</small>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-admin btn-admin-primary" style="padding:12px 30px;font-size:.95rem;">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                    <a href="dashboard.php" class="btn-outline-custom" style="padding:11px 24px;font-size:.9rem;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
