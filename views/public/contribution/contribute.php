<?php
/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Contribution
 */

queue_js_file('contribution-public-form');
$contributionPath = get_option('contribution_page_path');
if(!$contributionPath) {
    $contributionPath = 'contribution';
}
queue_css_file('form');

//load user profiles js and css if needed
if(get_option('contribution_user_profile_type') && plugin_is_active('UserProfiles') ) {
    queue_js_file('admin-globals');
    queue_js_file('tinymce.min', 'javascripts/vendor/tinymce');
    queue_js_file('elements');
    queue_css_string("input.add-element {display: block}");
}

$head = array('title' => 'Contribute',
              'bodyclass' => 'contribution');
echo head($head); ?>
<script type="text/javascript">
// <![CDATA[
enableContributionAjaxForm(<?php echo js_escape(url($contributionPath.'/type-form')); ?>);
// ]]>
</script>
<?php
$loggedin = true;
if(! ($user = current_user() )&& !(get_option('contribution_open') )){
	$loggedin = false;
}
?>

<div id="primary" class="contribute">
<div class="row full">
        <div class="outer-text">
         <h1><?php echo $head['title']; ?></h1>
         <div class="expander">
			<div class="<?php if(!$loggedin){ echo 'expanded';}else{ echo 'expandable';}?>" >
			<p>The intention of this website and the Photobook Cafe is to build not only one of the worlds largest public libraries of self-published photobooks and zines but also to provide, through this website, a database of self-published photobooks and zines that anyone in the world can explore and discover some of these amazing works.</p>
<h3>How does it work?</h3>
<p>If you would like to contribute to this effort and help us to make this happen then the procedure is as follows: <a href="guest-user/user/register">Register</a> on the website so that you can become a contributor. Follow all the instructions on the ontribute page and make sure you have read all the <a href="contribution/terms">Terms & Conditions</a>. Submit your books/zines to the database. We will review them to ensure they meet the criteria set out below and then make them public on the site for everyone to see. You can contribute as many items as you like and anyone can submit whether you are the producer of the book/zine, a collector or a publisher, but please make sure you have all the required permissions. If we like the submission we will then request that you send us a physical copy of the item to include in the library here at the photobook cafe.</p>
<p>Please don't just send us unsolicited things as we will not be able to process them and will not be able to return them. You must use the procedure set out above.</p>
<h3>What's in it for you? </h3>
<p>Have your self-published photobook feature as part of the permanent archive database of books that people can browse online and discover your artistic output. This may well lead to people wanting to purchase your book/zine but we will not get involved in sales. If we request a copy of your book/zine and it is included in the permanent collection at the cafe then it will potentially be seen by thousands of visitors and they will be able to access all the information about the book through this site. We will from time to time feature books and zines that we like and promote them through our websites and social media as well as within the cafe itself through events and screenings.</p>
<h3>What are we looking for? </h3>
<p>Mainly self-published photobooks and zines. Works published through small publishers will also be considered but we want this to be about the individual artistic expression.We will have special collections for small publishers who support photographers publishing their first books or unusual books that wouldn't necessarily get a large publishing deal.</p>
<p>We are after personal projects that reflect a photographers artistic output. This can encompass any genre of photography. We don't care how you made it as long as you made it.</p>
<p>The books must not contain offensive material (we are not easily offended but will not tolerate anything that is grossly offensive or indecent or that would contraviene any publishing laws in the UK).</p>
<p>The copyright of all images in books or zines must be held by the author or they must have permission to use them. (no ripping people off).</p>
<p>All images of your book/zine that you upload must be of a suitable quality, as set out in the contribution form specification.</p>

			</div>
			<?php if($loggedin): ?>
			<div class="expand"><a href="">Read More</a></div>
			<?php endif ?>
		</div>
	
<?php echo flash(); ?>
    

    <?php if(! ($user = current_user() )
              && !(get_option('contribution_open') )
            ):
    ?>
        <?php $session = new Zend_Session_Namespace;
              $session->redirect = absolute_url();
        ?>
        <p>You must <a href='<?php echo url('guest-user/user/register'); ?>'>create an account</a> or <a href='<?php echo url('guest-user/user/login'); ?>'>log in</a> before contributing. </p>
                
    <?php else: ?>
        <form method="post" action="" enctype="multipart/form-data">
            <fieldset id="contribution-item-metadata">
                <div class="inputs">
                    <label for="contribution-type"><?php echo __("What type of item do you want to contribute?"); ?></label>
                    <?php $options = get_table_options('ContributionType' ); ?>
                    <?php $typeId = isset($type) ? $type->id : '' ; ?>
                    <?php echo $this->formSelect( 'contribution_type', $typeId, array('multiple' => false, 'id' => 'contribution-type') , $options); ?>
                    <input type="submit" name="submit-type" id="submit-type" value="Select" />
                </div>
                <div id="contribution-type-form">
                <?php if(isset($type)) { include('type-form.php'); }?>
                </div>
            </fieldset>

            <fieldset id="contribution-confirm-submit" <?php if (!isset($type)) { echo 'style="display: none;"'; }?>>
                <?php if(isset($captchaScript)): ?>
                    <div id="captcha" class="inputs"><?php echo $captchaScript; ?></div>
                <?php endif; ?>
                <?php echo $this->formHidden('contribution-public',1,null); ?>
                <?php echo $this->formHidden('contribution-anonymous',0,null); ?>
                <p><?php echo __("In order to contribute, you must read and agree to the %s",  "<a href='" . contribution_contribute_url('terms') . "' target='_blank'>" . __('Terms and Conditions') . ".</a>"); ?></p>
                <div class="inputs">
                    <?php $agree = isset( $_POST['terms-agree']) ?  $_POST['terms-agree'] : 0 ?>
                    <?php echo $this->formCheckbox('terms-agree', $agree, null, array('1', '0')); ?>
                    <?php echo $this->formLabel('terms-agree', __('I agree to the Terms and Conditions.')); ?>
                </div>
                <?php echo $this->formSubmit('form-submit', __('Contribute'), array('class' => 'submitinput')); ?>
            </fieldset>
            <?php echo $csrf; ?>
        </form>
    <?php endif; ?>
        </div>
    </div>
</div>
<?php echo foot();
