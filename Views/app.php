<!DOCTYPE html>
<html id="preload" class="preload" lang="ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description"
        content="Si tu propósito es aprender el nuestro es que lo hagas excelente. Aprende desde cero a crear el futuro web con nuestros Cursos Online Profesionales." />
    <meta property="og:site_name" content="<?= $title ?>">
    <meta property="og:title" content="<?= $title ?>" />
    <meta property="og:description" content="Si tu propósito es aprender el nuestro es que lo hagas excelente." />
    <meta property="og:image" itemprop="image" content="<?= SITE_URL ?>/img/og-cover-2.jpg">
    <meta property="og:type" content="website" />
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="<?= SITE_URL ?>/css/material-design-icons.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/css/vuetify.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/css/app-v1.0.0.min.css" rel="stylesheet">
    <?php if (!empty($data['styles'])): ?>
    <?php foreach ($data['styles'] as $style): ?>
    <?php if (isset($style['external']) AND $style['external']): ?>
    <link href="<?= $style['url']; ?>" rel="stylesheet">
    <?php else: ?>
    <link href="<?= SITE_URL ?>/assets/css/<?= $style['name']; ?>.css" rel="stylesheet">

    <?php endif ?>

    <?php endforeach ?>
    <?php endif ?>
</head>

<body class="body-preload">
    <?= new Controller\Template('parts/preloader') ?>
    <div id="full-learning-container">
        <!-- Sizes your content based upon application components -->
        <v-app class="preloading" light>
            <!-- Provides the application the proper gutter -->
            <?php if ($data['header']): ?>
            <?= new Controller\Template('parts/header') ?>
            <?php endif ?>
            <?php if ($data['admin_header']): ?>
            <?= new Controller\Template('admin/parts/header') ?>
            <?php endif ?>
            <v-content class="bg-white" tag="main">
                <v-container fluid>
                    <?= $content; ?>
                </v-container fluid>
            </v-content>
            <?php if ($data['footer']): ?>
            <?= new Controller\Template('parts/footer') ?>
            <?php endif ?>

        </v-app>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <?php if ($_SESSION['user_type'] !== 'administrador' && 1 == 2 ) : ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= GOOGLE_APP_ID ?>"></script>
    <script>
    /*
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', '<?= GOOGLE_APP_ID ?>');
    */
    </script>
    <?php endif ?>
    <script>
    <?php $id = (string) $_SESSION['user_id']; ?>
    var uid = "<?= Controller\Helper::encrypt($id);?>"
    const basic_info = {
        first_name: "<?= $_SESSION['first_name'] ?>",
        last_name: "<?= $_SESSION['last_name'] ?>",
        email: "<?= $_SESSION['email'] ?>",
        telephone: "<?= !empty($_SESSION['meta']['telephone']) ? $_SESSION['meta']['telephone'] : '' ?>",
    }
    </script>
    <?php endif ?>
    <script src="https://apis.google.com/js/api.js"></script>
    <script src="<?= SITE_URL ?>/js/preload.js"></script>
    <?php if (DEV_ENV) : ?>
    <script src="<?= SITE_URL ?>/js/vue.js"></script>
    <?php else: ?>
    <script src="<?= SITE_URL ?>/js/vue.pmin.js"></script>
    <?PHP endif ?>

    <script src="<?= SITE_URL ?>/js/components/vuetify.min.js"></script>
    <script src="<?= SITE_URL ?>/js/components/vue-resource.min.js"></script>
    <script src="<?= SITE_URL ?>/js/theme.js"></script>
    <script src="<?= SITE_URL ?>/js/setup.js"></script>
    <?php if (!empty($data['scripts'])): ?>
    <?php foreach ($data['scripts'] as $script): ?>
    <?php if (isset($script['external']) && $script['external']): ?>

    <script src="<?= $script['name']; ?>" <?php if (isset($data['props'])) echo $data['props'] ?>></script>

    <?php else: ?>

    <script
        src="<?= SITE_URL ?>/assets/js/<?= $script['name']; ?>.js<?= !empty($script['version']) ? "?v={$script['version']}" : '' ?>">
    </script>

    <?php endif ?>

    <?php endforeach ?>

    <?php if (isset($_SESSION['user_id'])): ?>
    <script src="<?= SITE_URL ?>/assets/js/notifications.min.js?v=v1.0.0"></script>
    <?php endif ?>

    <?php else: ?>
    <script src="<?= SITE_URL ?>/js/main.js"></script>
    <?php endif ?>

</body>

</html>