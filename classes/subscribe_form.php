<?php

require_once("phorms/phorms.php");
require_once("ReCAPTCHA_Widget.class.php");
require_once("ReCAPTCHA_Field.class.php");

class SubscribeForm extends Phorm_Phorm {
	protected function define_fields() {
		$this->name = new Phorm_Field_Text("Your Name", 40, 255, array('required'));
		$this->email = new Phorm_Field_Email("Email Address", 40, 255, array('required'));
		$this->phone = new Phorm_Field_Text("Phone Number", 40, 255);
		$this->school_name = new Phorm_Field_Text("School Name", 40, 255, array('required'));
		$this->school_address = new Phorm_Field_TextArea("School Address", 5, 40, array('required'));
		$this->more_teams = new Phorm_Field_CheckBox("Would you like to enter two teams if there is free space?");
		$this->captcha = new Phorm_Field_ReCAPTCHA("CAPTCHA");

		$this->phone->help_text("School Extension or Mobile");
	}
}

$form = new SubscribeForm();

?>
