<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?></title>
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

    <main class="container narrow">
        <a class="back-link" href="<?= BASE_URL ?>/participants">
            &larr; Kembali ke daftar
        </a>

        <section class="form-card">
            <p class="eyebrow">FORMULIR PESERTA</p>
            <h1><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="muted">
                Lengkapi seluruh informasi peserta di bawah ini.
            </p>

            <?php if (!empty($errors['general'])): ?>
                <div class="alert error">
                    <?= htmlspecialchars($errors['general']) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL . $formAction ?>">
                <?php if (!empty($participant['id'])): ?>
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $participant['id'] ?>"
                    >
                <?php endif; ?>

                <div class="field">
                    <label for="code">Kode Peserta *</label>
                    <input
                        id="code"
                        name="code"
                        maxlength="10"
                        required
                        value="<?= htmlspecialchars($participant['code'] ?? '') ?>"
                    >
                    <?php if (!empty($errors['code'])): ?>
                        <small class="field-error">
                            <?= htmlspecialchars($errors['code']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label for="name">Nama Lengkap *</label>
                    <input
                        id="name"
                        name="name"
                        maxlength="100"
                        required
                        value="<?= htmlspecialchars($participant['name'] ?? '') ?>"
                    >
                    <?php if (!empty($errors['name'])): ?>
                        <small class="field-error">
                            <?= htmlspecialchars($errors['name']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label for="email">Email *</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        maxlength="100"
                        required
                        value="<?= htmlspecialchars($participant['email'] ?? '') ?>"
                    >
                    <?php if (!empty($errors['email'])): ?>
                        <small class="field-error">
                            <?= htmlspecialchars($errors['email']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label for="institution">Institusi *</label>
                    <input
                        id="institution"
                        name="institution"
                        maxlength="100"
                        required
                        value="<?= htmlspecialchars($participant['institution'] ?? '') ?>"
                    >
                    <?php if (!empty($errors['institution'])): ?>
                        <small class="field-error">
                            <?= htmlspecialchars($errors['institution']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="field">
                    <label for="category">Kategori *</label>
                    <select id="category" name="category">
                        <option
                            value="GENERAL"
                            <?= ($participant['category'] ?? '') === 'GENERAL' ? 'selected' : '' ?>
                        >
                            GENERAL
                        </option>
                        <option
                            value="STUDENT"
                            <?= ($participant['category'] ?? '') === 'STUDENT' ? 'selected' : '' ?>
                        >
                            STUDENT
                        </option>
                    </select>

                    <?php if (!empty($errors['category'])): ?>
                        <small class="field-error">
                            <?= htmlspecialchars($errors['category']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <a class="btn secondary" href="<?= BASE_URL ?>/participants">
                        Batal
                    </a>
                    <button class="btn primary" type="submit">
                        Simpan Data
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
