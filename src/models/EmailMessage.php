<?php

namespace navatech\email\models;

use baibaratsky\yii\behaviors\model\SerializedAttributes;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 *
 * This is the model class for table "{{%email_message}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $priority
 * @property string  $from
 * @property string  $to
 * @property string  $subject
 * @property string  $text
 * @property string  $createdAt
 * @property string  $sentAt
 * @property string  $bcc
 * @property string  $files
 */
class EmailMessage extends ActiveRecord {

	const STATUS_NEW         = 0;

	const STATUS_IN_PROGRESS = 1;

	const STATUS_SENT        = 2;

	const STATUS_ERROR       = 3;

	public $files = [];

	public $bcc   = [];

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%email_message}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'timestamp'            => [
				'class'      => TimestampBehavior::className(),
				'attributes' => [
					static::EVENT_BEFORE_INSERT => ['createdAt'],
				],
				'value'      => new Expression('NOW()'),
			],
			'serializedAttributes' => [
				'class'      => SerializedAttributes::className(),
				'attributes' => [
					'files',
					'bcc',
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[
				[
					'status',
					'priority',
				],
				'integer',
			],
			[
				['text'],
				'string',
			],
			[
				[
					'createdAt',
					'sentAt',
					'files',
				],
				'safe',
			],
			[
				[
					'from',
					'to',
					'subject',
				],
				'string',
				'max' => 255,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'        => 'ID',
			'status'    => Yii::t('email', 'Status'),
			'priority'  => Yii::t('email', 'Priority'),
			'from'      => Yii::t('email', 'From'),
			'to'        => Yii::t('email', 'To'),
			'subject'   => Yii::t('email', 'Subject'),
			'text'      => Yii::t('email', 'Text'),
			'createdAt' => Yii::t('email', 'Created At'),
			'sentAt'    => Yii::t('email', 'Sent At'),
		];
	}
}
