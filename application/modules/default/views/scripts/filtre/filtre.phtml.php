<?php
$menus = Genius_Model_Menu::getAllMenus();
$page = Genius_Model_Page::getPageById(2);
?>
<!-- start subheader -->

<!-- start subheader -->
<section class="subHeader page" style="height:auto !important">
    <div class="container">
    </div><!-- end subheader container -->
</section>
<!-- end subheader section -->

<!-- start main content -->
<section class="properties pad_300">
    <div class="container">
        <div class="page_title2">
            <div class="pagenation">
                <div class="padding-top">&nbsp;
                    <a href="/">Home</a>
                    <i>/</i> <?php echo $page['title_'.DEFAULT_LANG_ABBR];?></div>
                <?php echo $this->render('statics/moteur_v1.phtml'); ?>
            </div>
        </div>
        <div class="divider" style="margin-top:1px"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col_blogPost">
                        <h1><?php echo $page['title_'.DEFAULT_LANG_ABBR];?> </h1>
                        <div class="divider"></div>
                        <div class="blogPost">
                            <?php echo $page['text_'.DEFAULT_LANG_ABBR];?>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end main content -->

<!-- start widgets section -->
<section class="genericSection2">
    <div class="container">
        <div class="row">
            <div class="hbigline1">&nbsp;</div>
        </div>
    </div>
    <?php echo $this->render('statics/carousel.phtml');?>
</section>
