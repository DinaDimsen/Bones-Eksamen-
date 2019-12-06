<?php
/**
 * Hootsuite API class
 * 
 * @package WP_To_Social_Pro
 * @author  Tim Carr
 * @version 1.0.0
 */
class WP_To_Social_Pro_Hootsuite_API {

    /**
     * Holds the base class object.
     *
     * @since   1.0.0
     *
     * @var     object
     */
    public $base;

    /**
     * Holds the Hootsuite Application's Client ID
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private $client_id = 'l7xx225f065c3e6e4da2b9e287824299f6de';

    /**
     * Holds the oAuth Gateway endpoint, used to exchange a code for an access token
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private $oauth_gateway_endpoint = 'https://www.wpzinc.com/?oauth=hootsuite';

    /**
     * Holds the API endpoint
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private $api_endpoint = 'https://platform.hootsuite.com/';

    /**
     * Holds the API version
     *
     * @since   1.0.0
     *
     * @var     string
     */
    private $api_version = 'v1';
    
    /**
     * Access Token
     *
     * @since   1.0.0
     *
     * @var     string
     */
    public $access_token = '';

    /**
     * Refresh Token
     *
     * @since   1.0.0
     *
     * @var     string
     */
    public $refresh_token = '';

    /**
     * Token Expiry Timestamp
     *
     * @since   1.0.0
     *
     * @var     int
     */
    public $token_expires = false;

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
     * Returns the oAuth 2 URL used to begin the oAuth process
     *
     * @since   1.0.0
     *
     * @return  string  oAuth URL
     */
    public function get_oauth_url() {

        // Define URL args
        $args = array(
            'client_id'     => $this->client_id,
            'response_type' => 'code',
            'scope'         => 'offline',
            'redirect_uri'  => $this->oauth_gateway_endpoint,
            'state'         => admin_url( 'admin.php?page=' . $this->base->plugin->name . '-settings' ),
        );

        // Return oAuth URL
        return $this->api_endpoint . 'oauth2/auth/?' . http_build_query( $args );

    }

    /**
     * Returns the Hootsuite URL where the user can connect their social media accounts
     * to Hootsuite
     *
     * @since   3.8.4
     *
     * @return  string  URL
     */
    public function get_connect_profiles_url() {

        // Return Connect Profiles URL
        return 'https://hootsuite.com/dashboard#/member';

    }

    /**
     * Returns the Hootsuite URL where the user can change the timezone for the
     * given profile ID.
     *
     * @since   3.8.1
     *
     * @param   string  $profile_id     Profile ID
     * @return  string                  Timezone Settings URL
     */
    public function get_timezone_settings_url( $profile_id = false ) {

        return 'https://hootsuite.com/dashboard';

    }

    /**
     * Sets this class' access and refresh tokens
     *
     * @since   1.0.0
     *
     * @param   string  $access_token    Access Token
     * @param   string  $refresh_token   Refresh Token
     * @param   mixed   $token_expires   Token Expires (false | timestamp)
     */
    public function set_tokens( $access_token = '', $refresh_token = '', $token_expires = false ) {

        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->token_expires = $token_expires;

    }

    /**
     * Gets a new Access Token by using the Refresh Token
     * assigned to this class, if the Access Token
     * is nearing expiration, or has already expired.
     *
     * @since   1.0.0
     *
     * @return  mixed   WP_Error | bool
     */
    public function update_access_token() {

        // Bail if we don't have a refresh token
        if ( ! $this->check_refresh_token_exists() ) {
            return new WP_Error( 'missing_refresh_token', __( 'No refresh token exists', $this->base->plugin->name ) );
        }

        // Bail if the access token hasn't yet expired
        if ( strtotime( '+5 minutes' ) < $this->token_expires ) {
            return false;
        }

        // Send request
        $result = wp_remote_get( $this->oauth_gateway_endpoint, array(
            'headers'   => array(
                'Content-Type'  => 'application/json',
            ),
            'body'      => array(
                'refresh_token' => $this->refresh_token,
            ),
            'timeout'   => 10,
        ) );

        // Fetch the body
        $body = json_decode( wp_remote_retrieve_body( $result ) );

        // Bail if an error occured
        if ( ! $body->success ) {
            return new WP_Error( 'wp_to_social_pro_hootsuite_api_update_access_token', sprintf( __( 'Error refreshing access token.  Hootsuite said: %s', $this->base->plugin->name ), $body->data ) );
        }

        // Set access and refresh tokens in this class now
        $this->set_tokens( $body->data->access_token, $body->data->refresh_token, strtotime( '+' . $body->data->expires_in . ' seconds' ) );

        // Store access and refresh tokens in the plugin settings
        $this->base->get_class( 'settings' )->update_tokens( 
            $body->data->access_token, 
            $body->data->refresh_token, 
            strtotime( '+' . $body->data->expires_in . ' seconds' )
        );

        // Done
        return true;

    }

    /**
     * Checks if an access token was set.  Called by any function which 
     * performs a call to the API
     *
     * @since   1.0.0
     *
     * @return  bool    Token Exists
     */
    private function check_access_token_exists() {

        if ( empty( $this->access_token ) ) {
            return false;
        }

        return true;

    }

    /**
     * Checks if a refresh token was set.  Called by any function which 
     * performs a call to the API
     *
     * @since   1.0.0
     *
     * @return  bool    Token Exists
     */
    private function check_refresh_token_exists() {

        if ( empty( $this->refresh_token ) ) {
            return false;
        }

        return true;

    }

    /**
     * Returns the User object
     *
     * @since   1.0.0
     *
     * @return  mixed   WP_Error | User object
     */
    public function user() {

        // Check access token
        if ( ! $this->check_access_token_exists() ) {
            return false;
        }

        // Run the main request
        return $this->get( 'me' );

    }

    /**
     * Returns a list of Social Media Profiles attached to the Hootsuite Account.
     *
     * @since   1.0.0
     *
     * @param   bool    $force                      Force API call (false = use WordPress transient)
     * @param   int     $transient_expiration_time  Transient Expiration Time
     * @return  mixed                               WP_Error | Profiles object
     */
    public function profiles( $force = false, $transient_expiration_time ) {

        // Check access token
        if ( ! $this->check_access_token_exists() ) {
            return false;
        }

        // Setup profiles array
        $profiles = array();

        // Check if our WordPress transient already has this data.
        // This reduces the number of times we query the API
        if ( $force || false === ( $profiles = get_transient( $this->base->plugin->name . '_hootsuite_api_profiles' ) ) ) {
            // Get user, which contains the timezone
            // Individual profiles do not have their own timezones vs. Buffer, where they do
            $timezone = false;
            $user = $this->user();
            if ( $user != false && ! is_wp_error( $user ) ) {
                if ( isset( $user->defaultTimezone ) ) {
                    $timezone = $user->defaultTimezone;
                }
            }

            // Get profiles
            $results = $this->get( 'socialProfiles' );

            // Check for errors
            if ( is_wp_error( $results ) ) {
                return $results;
            }

            // Check data is valid
            foreach ( $results as $result ) {
                // We don't support Instagram or Pinterest in the Free version
                if ( $this->base->plugin->name == 'wp-to-hootsuite' ) {
                    if ( $result->type == 'INSTAGRAM' || $result->type == 'PINTEREST' ) {
                        continue;
                    }
                }

                // Add profile to array
                $profiles[ $result->id ] = array(
                    'id'                => $result->id, // Hootsuite ID
                    'social_network_id' => $result->socialNetworkId, // Social Network (e.g. FB, Twitter) ID
                    'formatted_service' => $this->get_formatted_service( $result->type ),
                    'formatted_username'=> $result->socialNetworkUsername,
                    'service'           => $this->get_service( $result->type ),
                    'timezone'          => $timezone,
                );

                // Twitter's 2019 Developer Policies mean that the formatted username and profile image are no longer returned.
                // In turn, Hootsuite cannot provide this information, so we must directly query for it through the Twitter API.
                if ( $result->type == 'TWITTER' && empty( $profiles[ $result->id ]['formatted_username'] ) ) {
                    // Fetch Twitter username from the API
                    // The API class will check the transient first and use cached results if available
                    $twitter_username = $this->base->get_class( 'twitter_api' )->get_username_by_id( $profiles[ $result->id ]['social_network_id'], $transient_expiration_time );
                    if ( is_wp_error( $twitter_username ) ) {
                        continue;
                    }

                    // Add username to results
                    $profiles[ $result->id ]['formatted_username'] = $twitter_username;
                }
            }

            // Store profiles in transient
            set_transient( $this->base->plugin->name . '_hootsuite_api_profiles', $profiles, $transient_expiration_time );
        }

        // Return results
        return $profiles;

    }

    /**
     * Depending on the social media profile type, return the formatted service name.
     *
     * @since   1.0.0
     *
     * @param   string  $type   Social Media Profile Type
     * @return  string          Formatted Social Media Profile Service Name
     */
    private function get_formatted_service( $type ) {

        switch ( $type ) {

            case 'TWITTER':
                return __( 'Twitter', $this->base->plugin->name );
                break;

            case 'INSTAGRAM':
                return __( 'Instagram', $this->base->plugin->name );
                break;

            case 'FACEBOOKPAGE':
                return __( 'Facebook Page', $this->base->plugin->name );
                break;

            case 'FACEBOOK':
                return __( 'Facebook', $this->base->plugin->name );
                break;
                
            case 'LINKEDINCOMPANY':
                return __( 'LinkedIn Page', $this->base->plugin->name );
                break;

            case 'LINKEDIN':
                return __( 'LinkedIn', $this->base->plugin->name );
                break;

            case 'GOOGLEPLUSPAGE':
                return __( 'Google+ Page', $this->base->plugin->name );
                break;

            case 'PINTEREST':
                return __( 'Pinterest', $this->base->plugin->name );
                break;

            default:
                return '';

        }

    }

    /**
     * Depending on the social media profile type, return the service name.
     *
     * @since   1.0.0
     *
     * @param   string  $type   Social Media Profile Type
     * @return  string          Social Media Profile Service Name
     */
    private function get_service( $type ) {

        switch ( $type ) {

            case 'FACEBOOKPAGE':
            case 'FACEBOOKGROUP':
                return 'facebook';
                break;


            case 'TWITTER':
            case 'INSTAGRAM':
                return strtolower( $type );
                break;

            case 'LINKEDINCOMPANY':
            case 'LINKEDIN':
                return 'linkedin';
                break;

            case 'GOOGLEPLUSPAGE':
                return 'google';
                break;

            case 'PINTEREST':
                return 'pinterest';
                break;
            
            default:
                return '';

        }

    }

    /**
     * Creates an Update
     *
     * @since   1.0.0
     *
     * @param   array   $params     Status Parameters
     * @return  mixed               WP_Error | Update object
     */
    public function updates_create( $params ) {

        // Check access token
        if ( ! $this->check_access_token_exists() ) {
            return false;
        }

        // Convert parameters into Hootsuite REST API compatible params
        $status = array(
            'text'             => $params['text'],
            'socialProfileIds' => $params['profile_ids'],
        );

        // Scheduling
        if ( isset( $params['scheduled_at'] ) ) {
            $status['scheduledSendTime'] = str_replace( ' ', 'T', $params['scheduled_at'] ) . 'Z';   
        }

        // Media
        if ( isset( $params['media'] ) && isset( $params['media']['picture'] ) ) {
            // Upload the media to ow.ly
            $result = $this->base->get_class( 'owly_api' )->photo_upload( $params['media']['picture'] );
            
            // Bail if the upload failed
            if ( is_wp_error( $result ) ) {
                return $result;
            }

            // Define the ow.ly media URL
            $status['mediaUrls'] = array(
                array(
                    'url' => $result,
                ),
            );
        }

        // Pinterest
        if ( isset( $params['subprofile_ids'] ) && is_array( $params['subprofile_ids'] ) && count( $params['subprofile_ids'] ) > 0 ) {
            // If the subprofile is a URL, it'll be a Pinterest Board URL that we need to convert to a Board ID
            if ( filter_var( $params['subprofile_ids'][0], FILTER_VALIDATE_URL ) ) {
                // Fetch Pinterest Board ID from the API
                // The API class will check the transient first and use cached results if available
                $board_id = $this->base->get_class( 'pinterest_api' )->get_board_id_by_url( $params['subprofile_ids'][0], $this->base->get_class( 'common' )->get_transient_expiration_time() );
                if ( is_wp_error( $board_id ) ) {
                    return $board_id;
                }
            } else {
                $board_id = $params['subprofile_ids'][0];
            }

            // Define the extendedInfo array to include the Pinterest Board ID and Destination URL
            $status['extendedInfo'] = array(
                array(
                    'socialProfileType' => 'PINTEREST',
                    'socialProfileId'   => $params['profile_ids'][0],
                    'data'              => array(
                        'boardId'           => (string) $board_id,
                        'destinationUrl'    => $params['source_url'],
                    ),
                ),
            ); 
        }

        // Send request
        $result = $this->post( 'messages', $status );

        // Bail if the result is an error
        if ( is_wp_error( $result ) ) {
            return $result;
        }

        // Return array of just the data we need to send to the Plugin
        return array(
            'profile_id'            => $result[0]->socialProfile->id,
            'message'               => $result[0]->state,
            'status_text'           => $result[0]->text,
            'status_created_at'     => current_time( 'timestamp' ),
            'due_at'                => ( isset( $result[0]->scheduledSendTime ) ? strtotime( $result[0]->scheduledSendTime ) : current_time( 'timestamp' ) ),
        );

    }

    /**
     * Private function to perform a GET request
     *
     * @since  1.0.0
     *
     * @param  string  $cmd        Command (required)
     * @param  array   $params     Params (optional)
     * @return mixed               WP_Error | object
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
     * Main function which handles sending requests to the Hootsuite API
     *
     * @since   1.0.0
     *
     * @param   string  $cmd        Command
     * @param   string  $method     Method (get|post)
     * @param   array   $params     Parameters (optional)
     * @return  mixed               WP_Error | object
     */
    private function request( $cmd, $method = 'get', $params = array() ) {

        // Check required parameters exist
        if ( empty( $this->access_token ) ) {
            return new WP_Error( 'missing_access_token', __( 'No access token was specified', $this->base->plugin->name ) );
        }

        // Fetch a new access token and refresh token
        $result = $this->update_access_token();
        
        // Bail if something went wrong
        if ( is_wp_error( $result ) ) {
            return $result;
        }

        // Build endpoint URL
        $url = $this->api_endpoint . $this->api_version . '/' . $cmd;

        // Define the timeout
        $timeout = 10;

        /**
         * Defines the number of seconds before timing out a request to the Hootsuite API.
         *
         * @since   1.0.0
         *
         * @param   int     $timeout    Timeout, in seconds
         */
        $timeout = apply_filters( $this->base->plugin->filter_name . '_api_request', $timeout );

        // Request via WordPress functions
        $result = $this->request_wordpress( $url, $method, $params, $timeout );

        // Request via cURL if WordPress functions failed
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
            if ( is_wp_error( $result ) ) {
                $result = $this->request_curl( $url, $method, $params, $timeout );
            }
        }

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

        // Define headers
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        );

        // Send request
        switch ( $method ) {
            /**
             * GET
             */
            case 'get':
                $result = wp_remote_get( $url, array(
                    'headers'   => $headers,
                    'body'      => ( ! empty( $params ) ? json_encode( $params ) : '' ),
                    'timeout'   => $timeout,
                ) );
                break;
            
            /**
             * POST
             */
            case 'post':
                $result = wp_remote_post( $url, array(
                    'headers'   => $headers,
                    'body'      => ( ! empty( $params ) ? json_encode( $params ) : '' ),
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
        
        // Check for errors, handling them if possible
        if ( isset( $body->error ) ) {
            return new WP_Error( $body->error, $body->error_description );
        }
        if ( isset( $body->errors ) ) {
            // Build error
            $message = array();
            foreach ( $body->errors as $error ) {
                $message[] = $error->code . ': ' . $error->message;
            }
            return new WP_Error( 'wp_to_social_pro_hootsuite_api_request_wordpress', implode( "\n", $message ) );
        }

        // All OK, return data from the body response
        return $body->data;

    }

    /**
     * Performs POST and GET requests through PHP's curl_exec() function.
     *
     * If this function is called, request_wordpress() failed, most likely
     * due to a DNS lookup failure or CloudFlare failing to respond.
     *
     * We therefore use CURLOPT_RESOLVE, to tell cURL the IP address for the domain.
     *
     * @since   1.0.0
     *
     * @param   string  $url        URL
     * @param   string  $method     Method (post|get)
     * @param   array   $params     Parameters
     * @param   int     $timeout    Timeout, in seconds (default: 10)
     * @return  mixed               WP_Error | object
     */
    private function request_curl( $url, $method, $params, $timeout = 10 ) {

        // Define headers
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        );

        // Init
        $ch = curl_init();

        // Set request specific options
        switch ( $method ) {
            /**
             * GET
             */
            case 'get':
                curl_setopt_array( $ch, array(
                    CURLOPT_URL             => $url . '?' . ( ! empty( $params ) ? http_build_query( $params ) : '' ),
                    CURLOPT_RESOLVE         => array( 
                        str_replace( 'https://', '', $this->api_endpoint ) . ':443:52.1.58.91',
                        str_replace( 'https://', '', $this->api_endpoint ) . ':443:54.174.38.127',
                    ),
                ) );
                break;

            /**
             * POST
             */
            case 'post':
                curl_setopt_array( $ch, array(
                    CURLOPT_URL             => $url,
                    CURLOPT_POST            => true,
                    CURLOPT_POSTFIELDS      => ( ! empty( $params ) ? json_encode( $params ) : '' ),
                    CURLOPT_RESOLVE         => array( 
                        str_replace( 'https://', '', $this->api_endpoint ) . ':443:52.1.58.91',
                        str_replace( 'https://', '', $this->api_endpoint ) . ':443:54.174.38.127',
                    ),
                ) );
                break;
        }

        // Set shared options
        curl_setopt_array( $ch, array(
            CURLOPT_HTTPHEADER      => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->access_token,
            ),
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_CONNECTTIMEOUT  => $timeout,
            CURLOPT_TIMEOUT         => $timeout,
        ) );

        // Execute
        $result     = curl_exec( $ch );
        $http_code  = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        $error      = curl_error( $ch );
        curl_close( $ch );

        // If our error string isn't empty, something went wrong
        if ( ! empty( $error ) ) {
            return new WP_Error( $this->base->plugin->name . '_api_request_curl', $error );
        }

        // Fetch the body
        $body = json_decode( $result );

        // Check for errors
        if ( isset( $body->error ) ) {
            // Return the error
            return new WP_Error( $body->error, $body->error_description );
        }
        if ( isset( $body->errors ) ) {
            // Return the error
            return new WP_Error( $body->errors[0]->code, $body->errors[0]->message );
        }

        // All OK, return data from the body response
        return $body->data;

    }

}