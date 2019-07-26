<?php 
$head = array('title' => __('Contribution Terms of Service'));
echo head($head);
?>

<div id="primary">
<div class="outer-text">
<h1><?php echo $head['title']; ?></h1>
<?php echo get_option('contribution_consent_text'); ?>
</div>
</div>
<?php echo foot(); ?>
