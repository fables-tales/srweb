<?php if(!defined('PHORMS_ROOT')) { die('Phorms not loaded properly'); }

require_once(dirname(__FILE__).'/recaptcha/recaptchalib.php');

/**
 * Phorm_Widget_ReCAPTCHA
 */
class Phorm_Widget_ReCAPTCHA extends Phorm_Widget
{
	private $publickey = "6LdnVsUSAAAAAGcnp_Bo9Pr5jlEghPCcvWB4SlNx";

	/* The error message returned from the server */
	private $error_msg;

	public function __construct($error_msg='') {
		$this->error_msg = $error_msg;
	}

	/**
	 * Returns the field as serialized HTML.
	 *
	 * @param mixed $value the form widget's value attribute
	 * @param array $attributes key=>value pairs corresponding to HTML attributes' name=>value
	 * @return string the serialized HTML
	 */
	protected function serialize($value, array $attributes=array())
	{
		return recaptcha_get_html($this->publickey, $error=$this->error_msg, $use_ssl=true);
	}

}
