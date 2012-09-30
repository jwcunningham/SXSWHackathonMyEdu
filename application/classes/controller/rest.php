<?php
abstract class Controller_REST extends Controller {

    protected $_action_map = array
        (
         'GET' => 'index',
         'PUT' => 'update',
         'POST' => 'create',
         'DELETE' => 'delete',
        );

    protected $_action_requested = '';

    /**
     * Checks the requested method against the available methods. If the method
     * is supported, sets the request action from the map. If not supported,
     * the "invalid" action will be called.
     */
    public function before()
    {
        $this->_action_requested = $this->request->action();

        if ( ! isset($this->_action_map[$this->request->method()]))
        {
            $this->request->action('invalid');
        }
        else
        {
            $this->request->action($this->_action_map[$this->request->method()]);
        }

        return parent::before();
    }

    /**
     * Sends a 405 "Method Not Allowed" response and a list of allowed actions.
     */
    public function action_invalid()
    {
        // Send the "Method Not Allowed" response
        $this->request->status = 405;
        $this->request->headers['Allow'] = implode(', ', array_keys($this->_action_map));
    }

}
