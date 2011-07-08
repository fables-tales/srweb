<?php if(!defined('PHORMS_ROOT')) { die('Phorms not loaded properly'); }

require_once(dirname(__FILE__).'/recaptcha/recaptchalib.php');

/**
 * Phorm_Field_ReCAPTCHA
 *
 * A field for filtering out spam using ReCAPTCHA
 *
 */
class Phorm_Field_ReCAPTCHA extends Phorm_Field
{

	private $privatekey = "6LdnVsUSAAAAACsQer-PCh5o7Z-jzPT7mG5wQAxK";

	/**
	 * Stores the error message returned from the server
	 */
	private $error_msg;

	/**
	 * @param string $label the field's text label
	 * @param array $validators a list of callbacks to validate the field data
	 */
	public function __construct($label, array $validators=array())
	{
		parent::__construct($label, $validators, array());
		/* Set the value so that the validate function is called when the
		 * form is submitted */
		$this->value = "MAGIC_NUMBER";
	}

	/**
	 * Returns a new ReCAPTCHAWidget.
	 *
	 * @return ReCAPTCHAWidget
	 */
	public function get_widget()
	{
		return new Phorm_Widget_ReCAPTCHA($this->error_msg);
	}

	/**
	 * Validates that the CAPTCHA was entered correctly. Due to the way
	 * ReCAPTCHA works it is necessary to grab both the challenege and
	 * response fields from the submitted form data. This doesn't fit with
	 * how Phorms works and I can't see any other way of getting these two
	 * fields without using the _POST superglobal here.
	 *
	 * @param string $value
	 * @return null
	 * @throws Phorm_ValidationError
	 */
	public function validate($value)
	{
		$resp = recaptcha_check_answer ($this->privatekey,
		                                $_SERVER["REMOTE_ADDR"],
		                                $_POST["recaptcha_challenge_field"],
		                                $_POST["recaptcha_response_field"]);

		if( !$resp->is_valid )
		{
			$this->error_msg = $resp->error;
			throw new Phorm_ValidationError('validation_required');
		}
	}

	public function import_value($value)
	{
		return $value;
	}

	/* The ReCAPTCHA widget handles and displays error messages on its own */
	public function errors($tag=TRUE) {
		return '';
	}
}
