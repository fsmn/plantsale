<?php
require 'vendor/autoload.php';

use \Aws\S3\S3Client;

/**
 * Class S3_client
 */
class S3_client  {

	private $client;

	function __construct() {
		$variables = [
			'version' => 'latest',
			'region' => 'nyc3',
			'endpoint' =>  'https://nyc3.digitaloceanspaces.com',
			'credentials' => [
				'key' => getenv('T7_S3_KEY'),
				'secret' => getenv('T7_S3_SECRET'),
			],
		];
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
			'Bucket' => getenv('S3_BUCKET', 't7-live-fsmn'),
			'Key' => getenv('S3_KEY', 'db.friendsschoolplantsale.com/files') .'/'. $file_name,
			'EndPoint' =>  getenv('S3_ENDPOINT', 'nyc3.digitaloceanspaces.com'),
			'SourceFile' => $file['full_path'],
			'ContentType' => $type,
			'StorageClass' => 'STANDARD',
			'ACL' => 'public-read',
		];

		$insert = $this->client->putObject($variables);
		return $insert['ObjectURL'];
	}

	public function deleteFile($file_name) {
		$variables = [
			'Bucket' => getenv('S3_BUCKET', 't7-live-fsmn'),
			'Key' => getenv('S3_KEY', 'db.friendsschoolplantsale.com/files') . '/' . $file_name,
			'EndPoint' =>  getenv('S3_ENDPOINT', 'nyc3.digitaloceanspaces.com'),
		];
		$delete = $this->client->deleteObject($variables);
		return $delete;
	}

	public function getBucket() {
		return (object) [
			'Bucket' => getenv('S3_BUCKET', 't7-live-fsmn'),
			'Key' => getenv('S3_KEY', 'db.friendsschoolplantsale.com/files/'),
			'EndPoint' => getenv('S3_ENDPOINT', 'nyc3.digitaloceanspaces.com'),
		];
	}

	public function getPath() {
		$bucket = $this->getBucket();
		return 'https://' . $bucket->Bucket . '.'. $bucket->EndPoint . '/' . $bucket->Key;
	}

}
