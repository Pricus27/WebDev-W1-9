<?php
include 'connection.php';

// --- DELETE ---
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM journal WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $deleteId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: journal.php');
    exit;
}

// --- EDIT: load entry for form ---
$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$formTitle = '';
$formContent = '';
$formEntryDate = '';

if ($editId > 0) {
    $stmt = mysqli_prepare($conn, "SELECT id, title, content, entry_date FROM journal WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $editId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
        $formTitle = htmlspecialchars($row['title']);
        $formContent = htmlspecialchars($row['content']);
        $formEntryDate = $row['entry_date'];
    }
    mysqli_stmt_close($stmt);
}

// --- ADD or UPDATE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $entryDate = trim($_POST['entry_date'] ?? '');

    if ($title !== '' && $content !== '' && $entryDate !== '') {
        if ($editId > 0) {
            $stmt = mysqli_prepare($conn, "UPDATE journal SET title = ?, content = ?, entry_date = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'sssi', $title, $content, $entryDate, $editId);
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO journal (title, content, entry_date) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'sss', $title, $content, $entryDate);
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: journal.php');
        exit;
    }
}

// --- GET ALL ENTRIES ---
$result = mysqli_query($conn, "SELECT id, title, content, entry_date FROM journal ORDER BY entry_date DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .journal-card { max-width: 800px; margin: 0 auto; }
        .entry-content { white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container py-4 journal-card">
        <h1 class="mb-4">My Journal</h1>

        <!-- Add / Edit form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <?php echo $editId ? 'Edit Entry' : 'New Entry'; ?>
            </div>
            <div class="card-body">
                <form method="POST" action="journal.php<?php echo $editId ? '?edit=' . $editId : ''; ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $formTitle; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required><?php echo $formContent; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="entry_date" class="form-label">Entry Date</label>
                        <input type="date" class="form-control" id="entry_date" name="entry_date" value="<?php echo $formEntryDate ?: date('Y-m-d'); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $editId ? 'Update Entry' : 'Save Entry'; ?></button>
                    <?php if ($editId): ?>
                        <a href="journal.php" class="btn btn-outline-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- List of entries -->
        <div class="card shadow-sm">
            <div class="card-header">All Entries</div>
            <div class="card-body p-0">
                <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Entry Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo (int) $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><span class="entry-content"><?php echo htmlspecialchars(mb_substr($row['content'], 0, 80)); ?><?php echo mb_strlen($row['content']) > 80 ? '…' : ''; ?></span></td>
                                <td><?php echo htmlspecialchars($row['entry_date']); ?></td>
                                <td>
                                    <a href="?edit=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="?delete=<?php echo (int) $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this entry?');">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="p-3 mb-0 text-muted">No journal entries yet. Add one above.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
