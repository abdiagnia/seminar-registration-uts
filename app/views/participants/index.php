<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Peserta</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <strong>Seminar Registration</strong>
            <span>Panel Administrasi</span>
        </div>

        <div class="user-area">
            Halo, <?= htmlspecialchars($_SESSION['name'] ?? 'Administrator') ?>
            <a href="<?= BASE_URL ?>/logout">Keluar</a>
        </div>
    </header>

    <main class="container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">DATA SEMINAR</p>
                <h1>Daftar Peserta</h1>
                <p class="muted">
                    Kelola data pendaftaran peserta seminar STT Mandala.
                </p>
            </div>

            <a class="btn primary" href="<?= BASE_URL ?>/participants/create">
                + Tambah Peserta
            </a>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert success">
                <?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <div class="table-card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Institusi</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$participants): ?>
                            <tr>
                                <td colspan="7" class="empty">
                                    Belum ada data peserta.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($participants as $i => $p): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($p['code']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($p['name']) ?></td>
                                    <td><?= htmlspecialchars($p['email']) ?></td>
                                    <td><?= htmlspecialchars($p['institution']) ?></td>
                                    <td>
                                        <span class="tag">
                                            <?= htmlspecialchars($p['category']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a
                                                class="btn small secondary"
                                                href="<?= BASE_URL ?>/participants/edit/<?= (int) $p['id'] ?>"
                                            >
                                                Ubah
                                            </a>

                                            <form
                                                method="post"
                                                action="<?= BASE_URL ?>/participants/delete"
                                                onsubmit="return confirm('Yakin ingin menghapus peserta ini?')"
                                            >
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $p['id'] ?>"
                                                >
                                                <button class="btn small danger" type="submit">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="footer-note">
            Total peserta: <b><?= count($participants) ?></b>
        </p>
    </main>
</body>
</html>
