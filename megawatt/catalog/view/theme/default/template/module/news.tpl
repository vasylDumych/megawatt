<?php if ($news) { ?>
    <div class="box">
        <?php if ($header) { ?>
        <div class="box-heading">
            <span class="icon-news"><?php echo $customtitle; ?></span>
        </div>
        <?php } ?>
        <div class="box-content">
            <div class="box-news">
                <?php foreach ($news as $news_story) { ?>
                    <div class="news-item">
                        <?php if ($show_headline) { ?>
                            <div class="news-title">
                                <a href="<?php echo $news_story['href']; ?>"><?php echo $news_story['title']; ?></a>
                            </div>
                        <?php } ?>
                        <div class="news-date"><?php echo $news_story['posted']; ?></div>
                        <div class="news-desc">пппппппппппп
                            <?php if ($news_story['thumb']) { ?>
                                <div class="news-image">
                                    <a href="<?php echo $news_story['href']; ?>"><img src="<?= $news_story['thumb'] ?>"
                                                                                      alt="<?php echo $news_story['title']; ?>"
                                                                                      title="<?php echo $news_story['title']; ?>"></a>
                                </div>
                            <?php } ?>
                            <?php echo $news_story['preview']; ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="news-buttons">
                    <a href="<?php echo $newslist;?>" class="button">
                        <?php echo $buttonlist; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>