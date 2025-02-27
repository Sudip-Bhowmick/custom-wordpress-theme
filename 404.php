<?php
/**
 * The template for displaying 404 pages (Not Found)
 */
get_header(); 
?>
<style>
.page-title {
    text-align: center;
}

a.goback {
    font-size: 18px;
    text-align: center;
    background: #000;
    color: #fff;
    padding: 12px 36px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 500;
    margin-top: 40px;
    display: inline-block;
}

.not-found {
    text-align: center;
}
</style>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="error-404 not-found ptb_80">
            <h1 class="page-title"><?php esc_html_e('Oops! That page can’t be found.'); ?></h1>
            <a href="/" class="goback">Visit Homepage</a>
        </section>
    </main>
</div>

<?php

get_footer(); // Include your theme's footer
?>