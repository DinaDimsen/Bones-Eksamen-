<?php
/**
 * Owly API class
 * 
 * @package WP_To_Social_Pro
 * @author  Tim Carr
 * @version 1.0.0
 */
class WP_To_Social_Pro_Owly_API {

    /**
     * Holds the base class object.
     *
     * @since   1.0.0
     *
     * @var     object
     */
    public $base;

    /**
     * Holds the API endpoint
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private $api_endpoint = 'https://www.wpzinc.com/?api=owly';

    /**
     * Constructor
     *
     * @since   1.0.0
     *
     * @param   object $base    Base Plugin Class
     */
    public function __construct( $base ) {

        // Store base class
        $this->base = $base;

    }

    /**
     * Uploads a photo to ow.ly
     *
     * @since   1.0.0
     *
     * @param   string  $image_url  Image URL
     * @return  mixed   WP_Error | Update object
     */
    public function photo_upload( $image_url ) {

        // Send request
        return $this->post( 'photo/upload', array(
            'image_url' => $image_url,
        ) );

    }

	/**
	 * Private function to perform a GET request
	 *
	 * @since  1.0.0
	 *
	 * @param  string  $cmd 	   Command (required)
	 * @param  array   $params 	   Params (optional)
	 * @return mixed 		       WP_Error | object
	 */
	private function get( $cmd, $params = array() ) {

		return $this->request( $cmd, 'get', $params );

	}

	/**
	 * Private function to perform a POST request
	 *
     * @since  1.0.0
     *
     * @param  string  $cmd        Command (required)
     * @param  array   $params     Params (optional)
     * @return mixed               WP_Error | object
     */
	private function post( $cmd, $params = array() ) {

		return $this->request( $cmd, 'post', $params );

	}

	/**
     * Main function which handles sending requests to the ow.ly API
     *
     * @since   1.0.0
     *
     * @param   string  $cmd        Command
     * @param   string  $method 	Method (get|post)
     * @param   array   $params 	Parameters (optional)
     * @return  mixed               WP_Error | object
     */
    private function request( $cmd, $method = 'get', $params = array() ) {

    	// Build endpoint URL
    	$url = $this->api_endpoint . '&action=' . $cmd;

        // Define timeout, in seconds
        $timeout = apply_filters( $this->base->plugin->filter_name . '_api_request', 10 );

        // Request via WordPress functions
        $result = $this->request_wordpress( $url, $method, $params, $timeout );

        // Result will be WP_Error or the data we expect
        return $result;

    }

    /**
     * Performs POST and GET requests through WordPress wp_remote_post() and
     * wp_remote_get() functions
     *
     * @since   1.0.0
     *
     * @param   string  $url        URL
     * @param   string  $method     Method (post|get)
     * @param   array   $params     Parameters
     * @param   int     $timeout    Timeout, in seconds (default: 10)
     * @return  mixed               WP_Error | object
     */
    private function request_wordpress( $url, $method, $params, $timeout = 10 ) {

        // Send request
        switch ( $method ) {
            /**
             * GET
             */
            case 'get':
                $result = wp_remote_get( $url, array(
                    'body'      => ( ! empty( $params ) ? $params : '' ),
                    'timeout'   => $timeout,
                ) );
                break;
            
            /**
             * POST
             */
            case 'post':
                $result = wp_remote_post( $url, array(
                    'body'      => ( ! empty( $params ) ? $params : '' ),
                    'timeout'   => $timeout,
                ) );
                break;
        }

        // If an error occured, return it now
        if ( is_wp_error( $result ) ) {
            return $result;
        }

        // Fetch the body
        $body = json_decode( wp_remote_retrieve_body( $result ) );

        // Check for errors
        if ( ! $body->success ) {
            return new WP_Error(
                $this->base->plugin->filter_name . '_owly_api_request_wordpress_error',
                $body->data
            );
        }

        // All OK, return data from the body response
        return $body->data;

    }

}