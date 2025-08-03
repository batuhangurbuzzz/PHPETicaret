<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Sayfa Yönetimi</h1>
                <a href="/admin/pages/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="pageTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center align-middle" style="width: 5%;">#</th>
                                <th class="text-left align-middle" style="width: 20%;">Başlık</th>
                                <th class="text-left align-middle" style="width: 20%;">Slug</th>
                                <th class="text-center align-middle" style="width: 10%;">Durum</th>
                                <th class="text-center align-middle" style="width: 10%;">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index = 0;
                            foreach ($pages as $page):
                                $index++;
                                ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $index ?></td>
                                    <td class="text-left align-middle"><?= htmlspecialchars($page['title']) ?></td>
                                    <td class="text-left align-middle">
                                        <div class="d-flex align-items-center">
                                            <span id="slug-<?= $page['id'] ?>"><?= htmlspecialchars($page['slug']) ?></span>
                                            <button class="btn btn-outline-secondary btn-sm ms-2" onclick="copyToClipboard('<?= htmlspecialchars($page['slug']) ?>')">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle"><?= htmlspecialchars($page['status']) ?></td>
                                    <td class="text-center align-middle">
                                        <a href="/admin/pages/edit/<?= htmlspecialchars($page['id']) ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/pages/delete/<?= htmlspecialchars($page['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
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
    function copyToClipboard(slug) {
        const url = window.location.origin + '/page/' + slug;
        navigator.clipboard.writeText(url).then(function() {
            alert('URL kopyalandı: ' + url);
        }, function(err) {
            console.error('Kopyalama hatası: ', err);
        });
    }
    $(document).ready(function() {
        $('#pageTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 4]
            }]
        });
    });
</script>