<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace navatech\email\transports;

use Http\Adapter\Guzzle6\Client;
use navatech\email\interfaces\TransportInterface;
use yii\base\Component;
use yii\helpers\VarDumper;

class MailGun extends Component implements TransportInterface {

	public $apiKey;

	public $domain;

	/** @var \Mailgun\Mailgun */
	protected $_api;

	/**
	 * @param       $from
	 * @param       $to
	 * @param       $subject
	 * @param       $text
	 * @param array $files
	 * @param null  $bcc
	 *
	 * @return bool
	 */
	public function send($from, $to, $subject, $text, $files = [], $bcc = null) {
		$this->init();
		$postData = [
			'from'    => $from,
			'to'      => $to,
			'subject' => $subject,
			'html'    => $text,
		];
		try {
			$this->_api->sendMessage($this->domain, $postData, $files);
		} catch (\Exception $e) {
			\Yii::error('Send error: ' . $e->getMessage(), 'email\MailGun');
			\Yii::trace(VarDumper::dumpAsString($postData), 'email\MailGun');
			return false;
		}
		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function init() {
		assert(isset($this->apiKey));
		assert(isset($this->domain));
		parent::init();
		$client     = new Client();
		$this->_api = new \Mailgun\Mailgun($this->apiKey, $client);
	}
}