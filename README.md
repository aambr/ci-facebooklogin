CI Facebook API library
=======================

Easy to use, almost single-file Facebook API library for popular CodeIgniter PHP framework.
It's very easy to authenticate users with their Facebook account. It takes seconds to integrate it with working CI application.

### Usage
Edit config file with your defaults. Used config file is prepared to be used on several different enviroments depending on what You have inside ```ENV``` enviroment variable, default is 'dev'.

* Load it as any other lib ```$this->load->library('facebook');```
* Place login button on site, You can pass this to your template:
```'facebook_login_url' => $this->facebook->get_login_url()```
It will compute a link based on Your config settings.
* ```Facebbok::getAPI``` is used as a factory to spawn an object which will be used as a proxy to communicate with Facebook API after successful authentication of a user.
* Handle errors in try-catch block
* Use instantiated FacebookAPI object to call methods, ```/me``` for example

### Example controller
```php
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
```