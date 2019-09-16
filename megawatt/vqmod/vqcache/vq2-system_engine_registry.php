<?php
final class Registry {
	private $data = array();

		private static $instance;

            public static function getInstance() {
                return self::$instance;
            }

            public function __construct() {
                self::$instance = $this;
            }
		

	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	public function has($key) {
		return isset($this->data[$key]);
	}
}
?>