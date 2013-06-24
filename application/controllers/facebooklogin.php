<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FacebookLogin extends CI_Controller
{
    public function index()
	{
		$this->load->library('facebook');
		
		$code = $this->input->get('code');
		if (!empty($code)) {
			try {
				$profile = $this->facebook->getAPI($code)->call('/me');
				if (empty($profile)) {
					// handle empty profile error
				} else {
					$this->load->model('user');
					$user = $this->user->get_or_create($profile['email']);
					$user['facebook_username'] = $profile['username'];
					$user['first_name'] = $profile['first_name'];
					$user['last_name'] = $profile['last_name'];
					$this->user->save($user)->login($user);
					redirect('/user_area');
				}
			} catch(Exceptiion $e) {
				// handle error
                // $e->getMessage() will return invalid response from Facebook
			}
		} else if ($error_reason = $this->input->get('error_reason')) {
            // string error message from Facebook
		}
		
		redirect('/');
	}
}
