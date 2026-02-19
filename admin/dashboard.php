<?php
/**
 * admin/dashboard.php – Admin Dashboard
 * View stats, projects list, and recent messages.
 */

session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$db = getDB();

// Stats
$projectCount = $db->query('SELECT COUNT(*) FROM projects')->fetchColumn();
$messageCount = $db->query('SELECT COUNT(*) FROM messages')->fetchColumn();
$unreadCount  = $db->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();

// Projects
$projects = $db->query('SELECT * FROM projects ORDER BY created_at DESC')->fetchAll();

// Recent messages (latest 10)
$messages = $db->query('SELECT * FROM messages ORDER BY created_at DESC LIMIT 10')->fetchAll();

// Mark all messages read
$db->exec('UPDATE messages SET is_read = 1 WHERE is_read = 0');

// Handle project deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_project'])) {
    $pid = (int)($_POST['project_id'] ?? 0);
    if ($pid > 0) {
        // Delete image file if exists
        $row = $db->prepare('SELECT image FROM projects WHERE id = ?');
        $row->execute([$pid]);
        $r = $row->fetch();
        if ($r && $r['image'] && file_exists('../assets/images/' . $r['image'])) {
            @unlink('../assets/images/' . $r['image']);
        }
        $stmt = $db->prepare('DELETE FROM projects WHERE id = ?');
        $stmt->execute([$pid]);
    }
    header('Location: dashboard.php?deleted=1');
    exit;
}

$adminName = htmlspecialchars($_SESSION['admin_name'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin Panel – Saiwak Ram</title>
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
        <a href="dashboard.php" class="sidebar-nav-item active">
            <i class="bi bi-grid"></i><span class="nav-text">Dashboard</span>
        </a>
        <a href="add_project.php" class="sidebar-nav-item">
            <i class="bi bi-plus-circle"></i><span class="nav-text">Add Project</span>
        </a>
        <a href="../index.php" class="sidebar-nav-item" target="_blank">
            <i class="bi bi-eye"></i><span class="nav-text">View Portfolio</span>
        </a>
        <a href="logout.php" class="sidebar-nav-item" style="margin-top:auto;">
            <i class="bi bi-box-arrow-right"></i><span class="nav-text">Logout</span>
        </a>
    </nav>
    <div style="margin-top:auto;padding:20px 24px;border-top:1px solid var(--glass-border);">
        <div style="font-size:.78rem;color:var(--text-secondary);">Logged in as</div>
        <div style="font-size:.9rem;font-weight:600;"><?= $adminName ?></div>
    </div>
</aside>

<!-- Main Content -->
<div class="admin-main">
    <!-- Top Bar -->
    <div class="admin-topbar">
        <h1 style="font-size:1.1rem;font-weight:700;margin:0;">Dashboard</h1>
        <div class="d-flex align-items-center gap-3">
            <?php if ($unreadCount > 0) : ?>
            <span style="background:var(--accent-2);color:#fff;font-size:.75rem;font-weight:700;padding:4px 10px;border-radius:20px;">
                <?= $unreadCount ?> new msg<?= $unreadCount > 1 ? 's' : '' ?>
            </span>
            <?php endif; ?>
            <a href="logout.php" class="btn-outline-custom" style="padding:8px 18px;font-size:.85rem;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <div class="admin-content">
        <!-- Alerts -->
        <?php if (isset($_GET['deleted'])) : ?>
        <div class="alert" style="background:rgba(67,233,123,.15);border:1px solid rgba(67,233,123,.3);color:#43e97b;border-radius:10px;padding:12px 18px;margin-bottom:20px;">
            <i class="bi bi-check-circle me-2"></i>Project deleted successfully.
        </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background:var(--gradient-1);"><i class="bi bi-folder"></i></div>
                    <div class="stats-num"><?= $projectCount ?></div>
                    <div class="stats-lbl">Total Projects</div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background:var(--gradient-2);"><i class="bi bi-envelope"></i></div>
                    <div class="stats-num"><?= $messageCount ?></div>
                    <div class="stats-lbl">Total Messages</div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background:var(--gradient-3);"><i class="bi bi-bell"></i></div>
                    <div class="stats-num"><?= $unreadCount ?></div>
                    <div class="stats-lbl">Unread Messages</div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);"><i class="bi bi-person-check"></i></div>
                    <div class="stats-num">1</div>
                    <div class="stats-lbl">Admin Users</div>
                </div>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="bg-glass rounded-custom p-4 mb-4" style="border:1px solid var(--glass-border);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="font-weight:700;margin:0;">Projects</h5>
                <a href="add_project.php" class="btn-admin btn-admin-primary">
                    <i class="bi bi-plus-lg"></i> Add Project
                </a>
            </div>

            <?php if (empty($projects)) : ?>
                <p style="color:var(--text-secondary);font-size:.88rem;">No projects yet. Click "Add Project" to get started.</p>
            <?php else : ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Technologies</th>
                            <th>GitHub</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $i => $p) : ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td style="font-weight:600;"><?= htmlspecialchars($p['title']) ?></td>
                            <td style="max-width:200px;font-size:.8rem;color:var(--text-secondary);">
                                <?= htmlspecialchars($p['technologies']) ?>
                            </td>
                            <td>
                                <?php if ($p['github_link']) : ?>
                                <a href="<?= htmlspecialchars($p['github_link']) ?>" target="_blank" rel="noopener noreferrer" style="color:var(--accent);">
                                    <i class="bi bi-github"></i> Link
                                </a>
                                <?php else : ?>
                                <span style="color:var(--text-secondary);">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:.8rem;color:var(--text-secondary);">
                                <?= date('d M Y', strtotime($p['created_at'])) ?>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="edit_project.php?id=<?= $p['id'] ?>" class="btn-admin btn-admin-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="dashboard.php" onsubmit="return confirm('Delete \'<?= htmlspecialchars(addslashes($p['title'])) ?>\'? This cannot be undone.');">
                                        <input type="hidden" name="delete_project" value="1">
                                        <input type="hidden" name="project_id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="btn-admin btn-admin-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Messages Table -->
        <div class="bg-glass rounded-custom p-4" style="border:1px solid var(--glass-border);">
            <h5 style="font-weight:700;margin-bottom:20px;">Recent Messages</h5>

            <?php if (empty($messages)) : ?>
                <p style="color:var(--text-secondary);font-size:.88rem;">No messages received yet.</p>
            <?php else : ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $i => $msg) : ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td style="font-weight:600;"><?= htmlspecialchars($msg['name']) ?></td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" style="color:var(--accent);font-size:.85rem;">
                                    <?= htmlspecialchars($msg['email']) ?>
                                </a>
                            </td>
                            <td style="font-size:.85rem;"><?= htmlspecialchars($msg['subject']) ?></td>
                            <td style="font-size:.82rem;color:var(--text-secondary);max-width:220px;">
                                <?= htmlspecialchars(mb_strimwidth($msg['message'], 0, 80, '…')) ?>
                            </td>
                            <td style="font-size:.8rem;color:var(--text-secondary);white-space:nowrap;">
                                <?= date('d M Y H:i', strtotime($msg['created_at'])) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
