<div class="section">
<?php if ($module_title){ ?>
<h3 class="section_title"><?php echo $module_title; ?></h3>
<?php } ?>
<?php foreach($sections as $section){ ?>
<div class="faq-single">
	<div class="faq-heading <?php echo $module; ?>">
		<p class="faq-q"><?php echo $qustion_title; ?></p>
		<?php echo $section['title']; ?>
	</div> 
	<div class="faq-answer">
		<p class="faq-a"><?php echo $answear_title; ?></p>	
		<?php echo $section['description']; ?>
	</div>
</div>
<?php } ?>
</div>

<script type="text/javascript">
//$(document).ready(function(){
//$('.hidden').next().remove();
//$('.hidden').remove();
//$(".faq-heading.<?php echo $module; ?>").click(function() {
//$(this).toggleClass("active");
//$(this).next(".faq-answer").slideToggle( 400, function() {
// Animation complete.
}); }); });
</script>

<style>
.section {margin-bottom:35px;}
.section_title {font-size:24px;margin-bottom:13px;font-weight:normal;}
.faq-single {
    border-bottom: none;
    margin-bottom: 5px;
    position: relative;
    border-radius: 3px;
    padding-bottom: 20px;
    border-bottom: 1px dotted #d2d2d2;
}
.faq-heading {
    font-size: 14px;
    padding: 11px 25px 11px 12px;
    line-height: 16px;
    cursor: pointer;
    transition: all 500ms ease;
}
.faq-heading:hover, .faq-heading.active {background-color:#f9f9f9;}
.faq-heading.active {background-position:100% 0px; background-repeat:no-repeat;}
.faq-answer {
    display: block;
    line-height: 18px;
    padding: 15px 15px 15px 35px;
    background: #fff;
    box-shadow: 0px 2px 2px #ccc;
}
.faq-q {
    background: url(/image/data/faq-q.png) 0% 0% no-repeat;
    height: 25px;
    padding-left: 30px;
    line-height: 25px;
	color: #34aa37;
    font-size: 20px;
}
.faq-a {
    background: url(/image/data/faq-a.png) 0% 0% no-repeat;
    height: 25px;
    padding-left: 30px;
    line-height: 25px;
	color: #34aa37;
    font-size: 20px;
}
</style>