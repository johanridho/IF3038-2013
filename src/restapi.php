<?php
    class RestApi {
        private $method;
        private $action;
        private $url = 'broooo';
        
        public function receiveRequest() {
            
        }
        
        public function sendResponse() {
            
        }
        
        public function processRequest() {
            $this->method = $_SERVER['REQUEST_METHOD'];            
            $this->url = $_SERVER['PATH_INFO'];
            $path = array_reverse(explode("/", $this->url));
            $this->action = $path[0];
        }
        
        public function getMethod() {
            return $this->method;
        }
        
        public function getUrl() {
            return $this->url;
        }
        
        public function getAction() {
            return $this->action;
        }
        
        
        
    }
?>