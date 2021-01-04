<?php

class Template
{

	public $id;
	public $code;
	public $module;
	public $type;
	public $subject;
	public $contentHtml;
	public $contentPlain;
	public $language;

	public function convertFormData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->code = (isset($data['code'])) ? $data['code'] : '';
		$this->module = (isset($data['module'])) ? $data['module'] : '';
		$this->type = (isset($data['type'])) ? $data['type'] : '';
		$this->subject = (isset($data['subject'])) ? $data['subject'] : '';
		$this->contentHtml = (isset($data['contentHtml'])) ? $data['contentHtml'] : '';
		$this->contentPlain = (isset($data['contentPlain'])) ? $data['contentPlain'] : '';
		$this->language = (isset($data['language'])) ? $data['language'] : '';

	}

	public function convertDbData($data)
	{

		$this->id = (isset($data['id'])) ? $data['id'] : 0;
		$this->code = (isset($data['code'])) ? $data['code'] : '';
		$this->module = (isset($data['module'])) ? $data['module'] : '';
		$this->type = (isset($data['type'])) ? $data['type'] : '';
		$this->subject = (isset($data['subject'])) ? $data['subject'] : '';
		$this->contentHtml = (isset($data['content_html'])) ? $data['content_html'] : '';
		$this->contentPlain = (isset($data['content_plain'])) ? $data['content_plain'] : '';
		$this->language = (isset($data['language_code'])) ? $data['language_code'] : '';

	}

}
