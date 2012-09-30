<?php
class Controller_Services extends Controller_REST {
    public $_action_map = array(
        'GET' => 'get',
        'PUT' => 'put',
        'POST' => 'post',
        'DELETE' => 'delete',
        'HEAD' => 'head'
    );

    public $data = null;

    public $limit = 20;
    public $offset = 0;

    // Serialization parameters
    public $_format = 'json';
    public $_default_format = 'json';
    public $_default_content_type = 'application/json';
    public $_jsonp_callback = 'console.log';
    public $_content_types = array(
        'json' => 'application/json',
        'geojson' => 'application/json',
        'jsonp' => 'text/javascript',
        'php' => 'application/vnd.php.serialized',
        'kml' => 'application/vnd.google-earth.kml+xml',
        'form' => array(
            'application/x-www-form-urlencoded',
            'multipart/form-data'
            ),
        'csv' => 'text/csv'
    );

    public function before() {
        $pbefore = parent::before();
        if($this->request->method() === 'POST') {
            $this->request->posted_content_type = $this->_req_content_type();
            $this->request->posted_raw = file_get_contents('php://input');
            $this->request->posted_data = $this->_unserialize($this->request->posted_raw);
        } elseif($this->request->method() === 'PUT') {
            $this->request->put_content_type = $this->_req_content_type();
            $this->request->put_raw = Request::$raw_req_body;
            $this->request->put_data = $this->_unserialize($this->request->put_raw);
        } else {
            if(isset($_GET['f'])) {
                $this->_format = $_GET['f'];
            } elseif($this->request->param('format')) {
                $this->_format = $this->request->param('format');
            } else {
                $this->_format = $this->_default_format;
            }
            if($this->_format === 'jsonp') {
                if(isset($_GET['callback']) && preg_match('/^[\w\.]+$/', $_GET['callback'])) {
                    $this->_jsonp_callback = $_GET['callback'];
                }
            }
            if(isset($_GET['l'])) {
                $this->limit = (int)$_GET['l'];
            }
            if(isset($_GET['o'])) {
                $this->offset = (int)$_GET['o'];
            }
        }
        try {
            $this->_auth_current_user();
        } catch(Exception $e) {
            $this->_forbidden($e->getMessage());
            $this->after();
            $this->request->send_headers();
            print $this->response;
            die();
        }
        return $pbefore;
    }

    public function after() {
        $this->response->body($this->_serialize($this->data));
        $this->response->headers('Content-Type', 'application/json');
        return parent::after();
    }

    protected function _serialize($d) {
        return json_encode($d);
    }

    protected function _auth_current_user() {
        $this->_current_user = Auth::instance()->get_user() || false;
    }
}
