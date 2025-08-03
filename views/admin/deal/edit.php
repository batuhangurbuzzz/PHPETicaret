<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kampanya Düzenle</h1>
        <a href="/admin/deal" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/deal/update/<?= htmlspecialchars($deal['id']) ?>" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($deal['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($deal['content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($deal['start_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Bitiş Tarihi</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="<?= htmlspecialchars($deal['end_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1" <?= $deal['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $deal['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>