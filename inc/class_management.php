<?php

require_once('env.php');

class Management {
	public function __construct() {	
		global $creds;
		$this->creds = $creds;
		try {
			$this->db = new PDO($creds->dsn,$creds->user,$creds->password);
		} catch (PDOException $e) {
			Pubmed::throw_error($e->getMessage());
		}
	}

	public function print_top_buttons() {
		?>
		<div id="action-buttons">
			<button class="btn btn-primary" data-action="add"><i class="fa fa-plus"></i> Add New</button>
		</div>
		<?php
	}

	public function query_execute() {
		try {
			$this->query->execute($this->query_parameters);
			$this->results = $this->query->fetchAll();
			return true;
		} catch (PDOException $e) {
			$this->throw_ajax_error($e->getMessage());
		}
	}
				
	public function return_ajax() {
		$message = new stdClass();
		$message->type = $this->ajax_type;
		$message->content = $this->ajax_content;
		print json_encode($message);
		exit;
	}
				
	public function throw_ajax_error($message) {
		$this->ajax_type = 'error';
		$this->ajax_content = $message;
		$this->return_ajax();
	}

	public static function throw_error($message) {
		print '<div class="user-alert alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button><p>'.$message.'</p></div>';
	}
}
