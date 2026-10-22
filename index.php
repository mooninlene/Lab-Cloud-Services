<?php
$pdo = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

if (isset($_GET['api']) && $_GET['api'] == 'true') {
    header('Content-Type: application/json');
    echo json_encode($pdo->query("SELECT * FROM custom_orders")->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO custom_orders (customer_name, menu_item, sweetness_level, sauce_preference) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['customer'], $_POST['menu'], $_POST['sweetness'], $_POST['sauce']]);
    } elseif (isset($_POST['serve'])) {
        $pdo->prepare("UPDATE custom_orders SET status='Served' WHERE id=?")->execute([$_POST['id']]);
    } elseif (isset($_POST['delete'])) {
        $pdo->prepare("DELETE FROM custom_orders WHERE id=?")->execute([$_POST['id']]);
    }
    header("Location: index.php");
    exit;
}

$orders = $pdo->query("SELECT * FROM custom_orders ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Smart POS - Custom Modifier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>☕ Smart POS Terminal</h2>
            <a href="?api=true" target="_blank" class="btn btn-outline-dark">Cek Output API (JSON)</a>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="POST" class="row g-2">
                    <div class="col-md-2">
                        <input type="text" name="customer" class="form-control" placeholder="Nama/Meja" required>
                    </div>
                    <div class="col-md-3">
                        <select name="menu" class="form-select" required>
                            <option value="">Pilih Menu...</option>
                            <optgroup label="Makanan">
                                <option value="Nasi Ayam Rempah Tedja">Nasi Ayam Rempah Tedja</option>
                                <option value="Nasi Kulit Lada Garam">Nasi Kulit Lada Garam</option>
                                <option value="Nasi Ayam Merah">Nasi Ayam Merah</option>
                                <option value="Bakmie Ayam Rica Rica">Bakmie Ayam Rica Rica</option>
                                <option value="Roasted Sesame Salad">Roasted Sesame Salad</option>
                                <option value="Smoky Garden Fries">Smoky Garden Fries</option>
                                <option value="Nasi Iga Bakar Kuah Asam">Nasi Iga Bakar Kuah Asam</option>
                            </optgroup>
                            <optgroup label="Minuman">
                                <option value="Power Latte">Power Latte</option>
                                <option value="Coco Matcha">Coco Matcha</option>
                                <option value="Recovery Mocha">Recovery Mocha</option>
                                <option value="Es Kopi Susu Tedja">Es Kopi Susu Tedja</option>
                                <option value="Peach on Black">Peach on Black</option>
                                <option value="Dirty Latte">Dirty Latte</option>
                                <option value="Mont Blanc">Mont Blanc</option>
                                <option value="Tiger Latte">Tiger Latte</option>
                                <option value="Cocoricano">Cocoricano</option>
                                <option value="Vanilla Regal">Vanilla Regal</option>
                                <option value="Milkshake Strawberry">Milkshake Strawberry</option>
                                <option value="Apple Mint Tea">Apple Mint Tea</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="sweetness" class="form-select">
                            <option value="Normal">Gula Normal</option>
                            <option value="50% (Balanced)">50% (Balanced)</option>
                            <option value="30% (Slightly Sweet)">30% (Slightly Sweet)</option>
                            <option value="Less Sugar">Less Sugar</option>
                            <option value="Zero Sugar">Zero Sugar</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sauce" class="form-select">
                            <option value="Normal">Catatan Normal</option>
                            <option value="Tanpa Saus Tomat & Sambal">Tanpa Saus Tomat & Sambal</option>
                            <option value="Pisah Kuah/Saus">Pisah Kuah/Saus</option>
                            <option value="Extra Pedas">Extra Pedas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="add" class="btn btn-primary w-100">Order</button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr><th>ID</th><th>Pelanggan</th><th>Menu</th><th>Catatan Khusus (Modifier)</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><?= $o['id'] ?></td>
                    <td class="fw-bold"><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td><?= htmlspecialchars($o['menu_item']) ?></td>
                    <td>
                        <span class="badge bg-info text-dark"><?= $o['sweetness_level'] ?></span>
                        <span class="badge bg-warning text-dark"><?= $o['sauce_preference'] ?></span>
                    </td>
                    <td><?= $o['status'] == 'Preparing' ? '⏳ Preparing' : '✅ Served' ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $o['id'] ?>">
                            <?php if($o['status'] == 'Preparing'): ?>
                                <button type="submit" name="serve" class="btn btn-sm btn-success">Serve</button>
                            <?php endif; ?>
                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>