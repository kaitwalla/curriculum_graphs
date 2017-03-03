<?php
require_once('env.php');

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
				$this->throw_error($e->getMessage());
			}

			$this->load_graph();
			$this->build_graph();
		}

		// Building functions
		public function build_break($break_name) {
			$break = $this->breaks->{$break_name};
			?>
				<div data-name="<?php print $break->name; ?>" class="track-item break units-<?php print $break->location->units; ?>">
					<h3><?php print $break->abbreviation; ?></h3>
					<p><?php print $break->name; ?></p>
				</div>
			<?php
			$this->current_position = $this->current_position + $break->location->units;
		}

		public function build_graph() {
			$this->file = file_get_contents('json/'.$this->results['file_url']);
			$this->json = json_decode($this->file);
			$this->setup_breaks();
			?>
				<div class="graph-container">
					<div class="graph-slider units-<?php print count($this->json->date_sections->titles) * $this->json->date_sections->units_per_section; ?>">
						<div class="graph-header">
							<?php $this->build_headers(); ?>
						</div>
						<div class="graph-body">
							<?php
								foreach ($this->json->tracks as $track) {
									$this->build_track($track);
								}
							?>
						</div>
					</div>
				</div>
			<?php
		}

		public function build_headers() {
			foreach ($this->json->date_sections->titles as $title) {
				?><div class="title units-<?php print $this->json->date_sections->units_per_section; ?>"><h2><?php print $title; ?></h2></div><?php
			}
		}

		public function build_track($track) {
			?>
			<div class="track"><?php
				$starting_position = 0;
				if (isset($this->json->date_sections->spacer_before) && $this->json->date_sections->spacer_before !== 0) {
					$starting_position = $this->json->date_sections->spacer_before;
					?>
					<div class="track-item spacer units-<?php print $this->json->date_sections->spacer_before; ?>"></div>
					<?php
				}
				$this->current_position = $starting_position;
				foreach ($track as $idx=>$track_item) {
					$this->check_for_breaks();
					?><div class="track-item units-<?php print $track_item->units; ?>">
						<h3><?php print $track_item->abbreviation; ?></h3>
						<p><?php print $track_item->name; ?></p>
					</div><?php
					$this->current_position = $this->current_position + $track_item->units;
				}
				$this->check_for_breaks(); ?>
			</div> <?php
		}

		public function check_for_breaks() {
			$potential_break_name = 'break'.$this->current_position;
			if (isset($this->breaks->{$potential_break_name})) {
				$this->build_break($potential_break_name);
			}
		}

		public function setup_breaks() {
			$this->breaks = new stdClass();
			foreach ($this->json->vertical_breaks as $break) {
				$name = 'break'.$break->location->start;
				$this->breaks->{$name} = $break;
			}
		}

		// Loading functions

		public function load_graph() {
			$query = $this->db->prepare('SELECT * FROM graphs WHERE id = :id');
			try {
				$query->execute(array('id'=>$this->id));
				$this->results = $query->fetchAll();
				$this->results = $this->results[0];
			} catch (PDOException $e) {
				$this->throw_error($e->getMessage());
			}
			return true;
		}

		public function load_json() {

		}

		// General functions

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