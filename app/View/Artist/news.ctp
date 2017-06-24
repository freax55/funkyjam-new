<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/artist-header-bg.jpg" alt="Funkyjam">
</header>


<div id="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <?= $this->BreadCrumb->show($path) ?>
            </div>


            <?= view::element('part_artist_nav') ?>
            <?php
            ?>
            <!-- text Section -->
            <div id="news-section">
                <?php
                // ワードプレスに該当する投稿がなければ予備のページを呼び出す
                if ($is_contents === true) {
                    print $content[0]['Post']['post_content'];
                } else {
                    $file_term = str_replace('/', '_', $term_name);
                    print view::element('content_' . $file_term);
                }
                ?>

                <!-- Pagination Section -->
                <?= View::element('pagination'); ?>
            </div>
        </div>
        
        <?= view::element('part_side_artist') ?>

        <?= view::element('part_artist_news') ?>

