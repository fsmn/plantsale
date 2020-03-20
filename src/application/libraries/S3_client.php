<?php
require 'vendor/autoload.php';

use \Aws\S3\S3Client;

/**
 * Class S3_client
 */
class S3_client  {

	private $client;

	private $bucket = 't7-live-fsmn';

	private $endpoint = 'nyc3.digitaloceanspaces.com';

	private $key;

	function __construct($vars) {
		$variables = [
			'version' => 'latest',
			'region' => 'nyc3',
			'endpoint' =>  'https://' . $this->endpoint,
			'credentials' => [
				'key' => $vars['key'],
				'secret' => $vars['secret'],
			],
		];
		if ($_SERVER['HTTP_HOST'] == 'db.friendsschoolplantsale.com') {
			$this->key =  'db.friendsschoolplantsale.com/files';
		}
		else {
			$this->key =  'db.friendsschoolplantsale.com/dev-files';
		}
		$this->client = new S3Client($variables);
	}


	/**
	 * @return array
	 */
	function listBuckets() {
		$spaces = $this->client->listBuckets();
		$output = [];
		foreach ($spaces['Buckets'] as $space) {
			$output[] = $space['Name'];
		}
		return $output;
	}

	/**
	 * @param $file_name
	 * @param $file
	 *
	 * @return mixed
	 */
	public function putFile($file_name, $file, $type = 'image/jpg') {
		$variables = [
			'Bucket' => $this->bucket,
			'Key' => $this->key .'/'. $file_name,
			'EndPoint' =>  $this->endpoint,
			'SourceFile' => $file['full_path'],
			'ContentType' => $type,
			'StorageClass' => 'STANDARD',
			'ACL' => 'public-read-write',
		];

		$insert = $this->client->putObject($variables);
		return $insert['ObjectURL'];
	}

	public function deleteFile($file_name) {
		$variables = [
			'Bucket' => $this->bucket,
			'Key' => $this->key . '/' . $file_name,
			'EndPoint' =>  $this->endpoint,
		];
		$delete = $this->client->deleteObject($variables);
		return $delete;
	}

	public function getPath() {
		return 'https://' . $this->bucket . '.'. $this->endpoint . '/' . $this->key;
	}

}
