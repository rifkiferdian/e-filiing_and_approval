<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $apps['judul_login'] ?> | Login</title>

    <link rel="shortcut icon" href="<?= base_url('assets/dist/img/logo_ww.png') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #5b21b6;
            --accent: #f59e0b;
            --ink: #17202a;
            --muted: #64748b;
            --line: #dbe3ea;
            --surface: #ffffff;
            --soft: #eef7f5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Source Sans Pro", Arial, sans-serif;
            color: var(--ink);
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
        }

        .login-shell {
            width: min(960px, 100%);
            min-height: 560px;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            overflow: hidden;
            background: var(--surface);
            border-radius: 8px;
            box-shadow: 0 22px 70px rgba(15, 23, 42, .28);
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 42px;
            color: #fff;
            background:
                linear-gradient(145deg, rgba(124, 58, 237, .9), rgba(91, 33, 182, .78)),
                url("<?= base_url('assets/dist/img/slider-9.jpeg') ?>") center/cover no-repeat;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, .04), rgba(0, 0, 0, .24));
            pointer-events: none;
        }

        .brand-panel > * {
            position: relative;
            z-index: 1;
        }

        .brand-mark {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-mark img {
            width: 68px;
            height: 68px;
            object-fit: contain;
            padding: 8px;
            background: rgba(255, 255, 255, .94);
            border-radius: 8px;
        }

        .brand-mark strong {
            display: block;
            font-size: 20px;
            line-height: 1.2;
            font-weight: 700;
        }

        .brand-copy {
            max-width: 430px;
        }

        .brand-copy h1 {
            margin: 0 0 16px;
            font-size: 40px;
            line-height: 1.08;
            letter-spacing: 0;
            font-weight: 700;
        }

        .brand-copy p {
            margin: 0;
            font-size: 17px;
            line-height: 1.65;
            color: rgba(255, 255, 255, .88);
        }

        .brand-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .brand-stat {
            padding: 14px;
            min-height: 82px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 8px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(4px);
        }

        .brand-stat i {
            margin-bottom: 10px;
            color: #fde68a;
        }

        .brand-stat span {
            display: block;
            font-size: 13px;
            line-height: 1.3;
            color: rgba(255, 255, 255, .88);
        }

        .form-panel {
            display: flex;
            align-items: center;
            padding: 46px;
            background: #fff;
        }

        .login-form {
            width: 100%;
        }

        .form-logo {
            display: none;
            width: 66px;
            height: 66px;
            object-fit: contain;
            margin-bottom: 18px;
        }

        .login-form h2 {
            margin: 0 0 8px;
            font-size: 28px;
            line-height: 1.2;
            font-weight: 700;
            color: var(--ink);
        }

        .login-form .hint {
            margin: 0 0 26px;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.5;
        }

        .alert {
            margin: 0 0 18px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.4;
        }

        .alert-danger {
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert-success {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #7f8da3;
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            height: 50px;
            padding: 0 16px 0 46px;
            border: 1px solid var(--line);
            border-radius: 8px;
            outline: none;
            color: var(--ink);
            background: #fff;
            font-size: 15px;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .input-wrap input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(124, 58, 237, .14);
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: #b91c1c;
            font-size: 13px;
            line-height: 1.35;
        }

        .submit-btn {
            width: 100%;
            height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: var(--primary);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
            box-shadow: 0 10px 22px rgba(124, 58, 237, .24);
        }

        .submit-btn:hover,
        .submit-btn:focus {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(124, 58, 237, .28);
        }

        .secure-note {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: var(--muted);
            font-size: 13px;
        }

        .secure-note i {
            color: var(--accent);
        }

        @media (max-width: 820px) {
            .login-shell {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                padding: 34px 24px;
            }

            .form-logo {
                display: block;
            }
        }

        @media (max-width: 420px) {
            .login-page {
                align-items: stretch;
                padding: 0;
            }

            .login-shell {
                border-radius: 0;
                box-shadow: none;
            }

            .form-panel {
                padding: 28px 18px;
            }

            .login-form h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <main class="login-page">
        <section class="login-shell">
            <aside class="brand-panel">
                <div class="brand-mark">
                    <img src="<?= base_url('assets/dist/img/logo_ww.png') ?>" alt="<?= $apps['judul_login'] ?>">
                    <strong><?= $apps['judul_login'] ?></strong>
                </div>

                <div class="brand-copy">
                    <h1>Kelola surat lebih tertib dan cepat.</h1>
                    <p><?= $apps['subjudul'] ?></p>
                </div>

                <div class="brand-stats" aria-hidden="true">
                    <div class="brand-stat">
                        <i class="fas fa-inbox"></i>
                        <span>Surat masuk</span>
                    </div>
                    <div class="brand-stat">
                        <i class="fas fa-paper-plane"></i>
                        <span>Surat keluar</span>
                    </div>
                    <div class="brand-stat">
                        <i class="fas fa-archive"></i>
                        <span>Arsip digital</span>
                    </div>
                </div>
            </aside>

            <div class="form-panel">
                <form action="<?= base_url('auth') ?>" method="POST" class="login-form">
                    <img class="form-logo" src="<?= base_url('assets/dist/img/logo_ww.png') ?>" alt="<?= $apps['judul_login'] ?>">
                    <h2>Masuk ke akun</h2>
                    <p class="hint">Gunakan User ID dan password yang sudah terdaftar.</p>

                    <?= $this->session->flashdata('message') ?>

                    <div class="form-group">
                        <label for="userid">User ID</label>
                        <div class="input-wrap">
                            <i class="fas fa-user"></i>
                            <input type="text" name="userid" id="userid" placeholder="Masukkan User ID" autocomplete="username" value="<?= set_value('userid') ?>">
                        </div>
                        <?= form_error('userid', '<small class="field-error">', '</small>') ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Masukkan password" autocomplete="current-password">
                        </div>
                        <?= form_error('password', '<small class="field-error">', '</small>') ?>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </button>

                    <div class="secure-note">
                        <i class="fas fa-shield-alt"></i>
                        <span>Akses hanya untuk pengguna yang berwenang.</span>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
