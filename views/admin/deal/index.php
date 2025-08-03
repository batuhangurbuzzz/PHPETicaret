<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Kampanya Yönetimi</h1>
                <a href="/admin/deal/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="dealTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 15%;">Başlık</th>
                                <th style="width: 30%;">İçerik</th>
                                <th style="width: 15%;">Başlangıç Tarihi</th>
                                <th style="width: 15%;">Bitiş Tarihi</th>
                                <th style="width: 5%;">Durum</th>
                                <th style="width: 10%;">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index = 0;
                            foreach ($deals as $deal):
                                $index++;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $index ?></td>
                                    <td><?= htmlspecialchars($deal['title']) ?></td>
                                    <td><?= htmlspecialchars($deal['content']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($deal['start_date']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($deal['end_date']) ?></td>
                                    <td class="text-center"><?= $deal['status'] == 1 ? 'Aktif' : 'Pasif' ?></td>
                                    <td class="text-center">
                                        <a href="/admin/deal/edit/<?= htmlspecialchars($deal['id']) ?>" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/deal/delete/<?= htmlspecialchars($deal['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
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
        $('#dealTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 6]
            }]
        });
    });
</script>