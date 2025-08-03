<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Ürün Yönetimi</h1>
                <a href="/admin/products/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="productTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center align-middle" style="width: 5%;">#</th>
                                <th class="text-center align-middle" style="width: 5%;">Standart Resim</th>
                                <th class="text-left align-middle" style="width: 25%;">İsim</th>
                                <th class="text-left align-middle" style="width: 20%;">Kategori</th>
                                <th class="text-center align-middle" style="width: 5%;">Galeri</th>
                                <th class="text-center align-middle" style="width: 5%;">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index = 0;
                            foreach ($products as $product):
                                $index++;
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $index ?></td>
                                    <td class="text-center align-middle"><img width="100px" src="<?= htmlspecialchars($product['standard_image']) ?>" alt="Product Image" class="img-fluid"></td>
                                    <td class="text-left align-middle"><?= htmlspecialchars($product['name']) ?></td>
                                    <td class="text-left align-middle"><?= htmlspecialchars($product['category_name']) ?></td>
                                    <td class="text-center align-middle">
                                        <a href="/admin/products/gallery/<?= htmlspecialchars($product['id']) ?>" class="btn btn-outline-secondary btn-sm">Galeri</a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="/admin/products/edit/<?= htmlspecialchars($product['id']) ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/products/delete/<?= htmlspecialchars($product['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
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
        $('#productTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 3]
            }]
        });
    });
</script>