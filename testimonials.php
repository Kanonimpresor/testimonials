<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * Render a form page to submit messages.
 */

if(!defined('e107_INIT'))
{
	require_once('../../class2.php');
}

if(!e107::isInstalled('testimonials'))
{
	header('Location: ' . e_BASE . 'index.php');
	exit;
}

// [PLUGINS]/testimonials/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('testimonials', false, true);

// Fallback: if language file didn't load (missing translation), load English directly.
if(!defined('LAN_TESTIMONIALS_01'))
{
	$fallback = e_PLUGIN . 'testimonials/languages/English/English_front.php';
	if(is_readable($fallback))
	{
		include_once($fallback);
	}
}

require_once(HEADERF);


class testimonials
{

	/**
	 * Store plugin preferences.
	 *
	 * @var mixed|null
	 */
	private $plugPrefs = null;

	/**
	 * Access to submit new testimonial item is granted or not.
	 *
	 * @var bool
	 */
	private $access = false;

	/**
	 * Constructor.
	 */
	function __construct()
	{
		// Get plugin preferences.
		$this->plugPrefs = e107::getPlugConfig('testimonials')->getPref();
		// Check user access.
		$this->access = check_class($this->plugPrefs['tm_submit_role']);

		if($this->access)
		{
			// If the form has been submitted.
			if(isset($_POST['tm_submit']) && (int) $_POST['tm_submit'] === 1)
			{
				// Process submitted form details.
				if($this->formValidate())
				{
					$this->formSubmit();
				}
			}

			$this->renderPage();
		}
		else
		{
			$this->renderErrorPage();
		}
	}


	/**
	 * Validate form details.
	 */
	function formValidate()
	{
		$db = e107::getDb();
		$tp = e107::getParser();
		$mes = e107::getMessage();

		$error = true;
		$messages = array();

		if(!isset($_POST['tm_name']) || empty($_POST['tm_name']))
		{
			$messages[] = LAN_TESTIMONIALS_08;
			$error = false;
		}

		if(!isset($_POST['tm_message']) || empty($_POST['tm_message']))
		{
			$messages[] = LAN_TESTIMONIALS_09;
			$error = false;
		}

		// If user is Anonymous, and nickname is exits in user table.
		if(!USER && (isset($_POST['tm_name'])))
		{
			// Check nickname's ownership.
			$nick = trim(preg_replace("#\[.*\]#si", "", $tp->toDB($_POST['tm_name'])));
			if($db->select("user", "*", "user_name='$nick' "))
			{
				$messages[] = LAN_TESTIMONIALS_10;
				$error = false;
			}
		}

		// Captcha validation.
		if(!empty($this->plugPrefs['tm_use_captcha']))
		{
			if(isset($_POST['rand_num']) && e107::getSecureImg()->invalidCode($_POST['rand_num'], $_POST['code_verify']))
			{
				$messages[] = LAN_TESTIMONIALS_12;
				$error = false;
			}
		}

		if(!$error)
		{
			foreach($messages as $message)
			{
				$mes->addError($message);
			}
		}

		return $error;
	}


	/**
	 * Insert form details into database.
	 */
	function formSubmit()
	{
		$db = e107::getDb();
		$tp = e107::getParser();
		$ip = e107::getIPHandler()->getIP(false);
		$mes = e107::getMessage();

		if(!USER && isset($_POST['nickname']))
		{
			$tm_name = 0 . '.' . trim(preg_replace("#\[.*\]#si", "", $tp->toDB($_POST['tm_name'])));
		}
		else
		{
			$tm_name = USERID . '.' . trim(preg_replace("#\[.*\]#si", "", $tp->toDB($_POST['tm_name'])));
		}

		$tm_url = trim(preg_replace("#\[.*\]#si", "", $tp->toDB($_POST['tm_url'])));

		$tm_message = $_POST['tm_message'];
		$tm_message = preg_replace("#\[.*?\](.*?)\[/.*?\]#s", "\\1", $tm_message);

		$insert = array(
			'tm_id'        => 0,
			'tm_name'      => $tm_name,
			'tm_url'       => $tm_url,
			'tm_message'   => $tm_message,
			'tm_datestamp' => time(),
			'tm_blocked'   => (int) $this->plugPrefs['tm_approval'],
			'tm_ip'        => $ip,
			'tm_order'     => 0,
		);

		$result = $db->insert("testimonials", $insert);
		if($result)
		{
			// Get last inserted id.
			$insert['tm_id'] = $result;
			$event = e107::getEvent();
			// Trigger event.
			$event->trigger('testimonials_message_insert', $insert);

			$mes->addSuccess(LAN_TESTIMONIALS_11);

			unset($_POST);
		}
	}


	/**
	 * Render testimonial submit form.
	 * Modernized for Bootstrap 5.3 + Royal Bus palette.
	 */
	function renderPage()
	{
		$mes = e107::getMessage();
		$frm = e107::getForm();
		$tp  = e107::getParser();
		$action = e107::url('testimonials', 'index');

		$tm_name    = isset($_POST['tm_name']) ? $tp->post_toForm($_POST['tm_name']) : (USER ? USERNAME : '');
		$tm_url     = isset($_POST['tm_url']) ? $tp->post_toForm($_POST['tm_url']) : '';
		$tm_message = isset($_POST['tm_message']) ? $tp->post_toForm($_POST['tm_message']) : '';

		$form  = '<div class="testimonials-submit-form">';
		$form .= '<div class="tm-form-intro mb-4">';
		$form .= '<p class="text-muted"><i class="fas fa-quote-left me-2 text-primary-royal"></i>';
		$form .= LAN_TESTIMONIALS_06 . '</p>';
		$form .= '</div>';

		$form .= $frm->open('testimonials', 'post', $action, array(
			'class' => 'needs-validation',
			'id'    => 'testimonials-form',
			'novalidate' => 'novalidate',
		));

		// Name field.
		$form .= '<div class="mb-3">';
		$form .= '<label for="tm_name" class="form-label fw-semibold">';
		$form .= '<i class="fas fa-user me-1"></i> ' . LAN_TESTIMONIALS_03 . ' <span class="text-danger">*</span>';
		$form .= '</label>';
		$form .= $frm->text('tm_name', $tm_name, 100, array(
			'id'          => 'tm_name',
			'placeholder' => LAN_TESTIMONIALS_03,
			'required'    => 'required',
		));
		$form .= '</div>';

		// URL field.
		$form .= '<div class="mb-3">';
		$form .= '<label for="tm_url" class="form-label fw-semibold">';
		$form .= '<i class="fas fa-globe me-1"></i> ' . LAN_TESTIMONIALS_07;
		$form .= '</label>';
		$form .= $frm->text('tm_url', $tm_url, 255, array(
			'id'          => 'tm_url',
			'placeholder' => 'https://example.com',
		));
		$form .= '</div>';

		// Message field.
		$form .= '<div class="mb-3">';
		$form .= '<label for="tm_message" class="form-label fw-semibold">';
		$form .= '<i class="fas fa-comment-dots me-1"></i> ' . LAN_TESTIMONIALS_04 . ' <span class="text-danger">*</span>';
		$form .= '</label>';
		$form .= $frm->textarea('tm_message', $tm_message, 5, 80, array(
			'id'          => 'tm_message',
			'placeholder' => LAN_TESTIMONIALS_04,
			'required'    => 'required',
		));
		$form .= '</div>';

		// Captcha (if enabled in plugin preferences).
		if(!empty($this->plugPrefs['tm_use_captcha']))
		{
			$sec_img = e107::getSecureImg();
			$form .= '<div class="mb-3">';
			$form .= '<label class="form-label fw-semibold">';
			$form .= '<i class="fas fa-shield-alt me-1"></i> ' . LAN_TESTIMONIALS_13 . ' <span class="text-danger">*</span>';
			$form .= '</label>';
			$form .= '<div class="tm-captcha-wrapper d-flex align-items-center gap-3 flex-wrap">';
			$form .= $sec_img->renderImage();
			$form .= $sec_img->renderInput();
			$form .= '</div>';
			$form .= '</div>';
		}

		// Submit button.
		$form .= '<div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">';
		$form .= $frm->button('tm_submit', 1, 'submit', '<i class="fas fa-paper-plane me-2"></i>' . LAN_TESTIMONIALS_05, array(
			'id'    => 'tm_submit',
			'class' => 'btn btn-lg btn-royal-yellow',
		));
		$form .= '</div>';

		$form .= $frm->close();
		$form .= '</div>'; // .testimonials-submit-form

		$messages = $mes->render();
		e107::getRender()->tablerender(LAN_TESTIMONIALS_06, $messages . $form);
	}


	/**
	 * Render Access Denied page.
	 * Modernized for Bootstrap 5.3 + Royal Bus palette.
	 */
	function renderErrorPage()
	{
		$text  = '<div class="testimonials-access-denied text-center py-4">';
		$text .= '<div class="mb-3"><i class="fas fa-lock fa-3x text-muted"></i></div>';
		$text .= '<p class="lead text-muted">' . LAN_TESTIMONIALS_02 . '</p>';

		if(!USER)
		{
			$text .= '<a href="' . e_LOGIN . '" class="btn btn-royal-yellow mt-2">';
			$text .= '<i class="fas fa-sign-in-alt me-2"></i>' . LAN_TESTIMONIALS_14 . '</a>';
		}

		$text .= '</div>';
		e107::getRender()->tablerender(LAN_TESTIMONIALS_06, $text);
	}

}


new testimonials();

require_once(FOOTERF);
exit;
