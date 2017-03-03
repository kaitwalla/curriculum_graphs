<?php
	class Curriculum_graph {
		public function __construct($id) {
			global $creds;
			
			if (!$id) {
				$this->throw_error('Missing ID');
			} else {
				$this->id = $id;
			}

			$this->creds = $creds;
			try {
				$this->db = new PDO($creds->dsn,$creds->user,$creds->password);
			} catch (PDOException $e) {
				Pubmed::throw_error($e->getMessage());
			}

			$this->load_graph();
			$this->build_graph();
		}

		public function build_graph() {
			
		}

		public function load_graph() {
			$query = $this->db->prepare('SELECT * FROM GRAPHS WHERE id = :id');
			try {
				$this->query->execute($this->query_parameters);
				$this->results = $this->query->fetchAll();
			} catch (PDOException $e) {
				$this->throw_error($e->getMessage());
			}
		}

		public function load_json() {

		}

		public function print() {

		}

		public function throw_error($msg) {
			?><h2>Error</h2>
			<p><?php print $msg; ?></p>
			<?php
			exit;
		}
	}
?>