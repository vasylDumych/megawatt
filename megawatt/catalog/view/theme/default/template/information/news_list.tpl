<?php echo $header; ?>
<?php echo $content_top; ?>
<?php echo $column_left; ?>
    <div id="content">
        <?php echo $column_right; ?>
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
        <h1><?php echo $heading_title; ?></h1>

        <div class="content">
            <?php if (isset($news_data)) { ?>
                <?php foreach ($news_data as $news) { ?>
                    <div class="news" style="overflow: hidden; margin-bottom: 20px">
                        <div style="font-size: 16px; margin-bottom: 6px"><a
                                href="<?php echo $news['href']; ?>"><?php echo $news['title']; ?></a>
                        </div>
                        <strong class="news-date"><?php echo $news['posted']; ?></strong>

                        <div class="panelcontent">
                            <?php if ($news['thumb']) { ?>
                                <div class="news-image" style="float: left; margin-right: 8px">
                                    <a href="<?php echo $news['href']; ?>">
                                        <img src="<?= $news['thumb'] ?>" alt="<?php echo $news['title']; ?>"
                                             title="<?php echo $news['title']; ?>"/></a>
                                </div>
                            <?php } ?>
                            <?php echo $news['description']; ?>
                            <div class="btn-block">
                                <a class="button" href="<?php echo $news['href']; ?>"> <?php echo $text_more; ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="pagination"><?php echo $pagination; ?></div>
            <?php } else { ?>
                <p><?php echo $text_no_results; ?></p>
            <?php } ?>
        </div>
    </div>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>