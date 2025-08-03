<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Kategori Yönetimi</h1>
                <a href="/admin/categories/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="categoryTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 25%;">İsim</th>
                                <th style="width: 25%;">İkon</th>
                                <th style="width: 25%;">Açıklama</th>
                                <th style="width: 10%;">Durum</th>
                                <th style="width: 10%;">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index = 0;
                            foreach ($categories as $category):
                                $index++;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $index ?></td>
                                    <td><?= htmlspecialchars($category['name']) ?></td>
                                    <td><?= htmlspecialchars($category['icon']) ?></td>
                                    <td><?= htmlspecialchars($category['description']) ?></td>
                                    <td class="text-center"><?= $category['status'] == 1 ? 'Aktif' : 'Pasif' ?></td>
                                    <td class="text-center">
                                        <a href="/admin/categories/edit/<?= htmlspecialchars($category['id']) ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/categories/delete/<?= htmlspecialchars($category['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 5]
            }]
        });
    });
</script>