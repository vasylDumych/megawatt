<?php if ($news) { ?>
    <div class="box container newsbloc">
        <?php if ($header) { ?>
        <div class="box-heading-news">
            <span class="icon-news"><?php echo $customtitle; ?></span>
        </div>
        <?php } ?>
        <div class="box-content">
            <div class="box-news">
			
			
                <?php foreach ($news as $news_story) { ?>
                    <div class="news-item">
						<div class="news-caption">
                        <?php if ($show_headline) { ?>
                            <div class="news-title">
                                <a href="<?php echo $news_story['href']; ?>"><?php echo $news_story['title']; ?></a>
                            </div>
                        <?php } ?>
						
						<?php /* echo $news_story['preview']; */?>
						<!--<span><a class="newsreadmore" href="<?php echo $news_story['href']; ?>">[...]</a></span>-->
						</div>
                        <div class="news-desc">
                            <?php if ($news_story['thumb']) { ?>
                                <div class="news-image">
                                    <a href="<?php echo $news_story['href']; ?>"><img src="<?= $news_story['thumb'] ?>"
                                                                                      alt="<?php echo $news_story['title']; ?>"
                                                                                      title="<?php echo $news_story['title']; ?>"></a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>
			
				
            </div>
			    <div class="news-buttons">
                    <a href="<?php echo $newslist;?>">
                        <?php echo $buttonlist; ?>
                    </a>
                </div>
        </div>
    </div>
<?php } ?>
<script>
$(document).ready(function() {
	$(".box-news").owlCarousel({
		itemsCustom : [[320, 1],[600, 2],[768, 3],[992, 4],[1199, 6]],											   
		lazyLoad : true,
		navigation : true,
		dots : false,
		controls:false,
		navigationText: false,
		scrollPerPage : true
    }); 
}); 
</script>