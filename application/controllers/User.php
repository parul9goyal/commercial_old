<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct() {
		parent::__construct();

		// Load form helper library
		//$this->load->helper('form');

		// Load form validation library
		//$this->load->library('form_validation');

		// Load session library
		//$this->load->library('session');

		// Load database
		//$this->load->model('user_database');
		
		//Loading url helper
		//$this->load->helper('url');
                $this->load->model('department_model');
	}
	 	
	public function index()
	{	
            $this->load->model('user_database'); 
            $result = $this->user_database->userlist_info();
            $data = array(
                'userdata' => $result,			
            );
//            echo "<pre/>";
//            print_r($data);die(000);
            $this->load->view('user_list',$data);
	}
	
	public function add_user()
	{ 
            
          $data['departments']=$this->department_model->department_lists();
         
       // print_r($data);
        //die();
		if($this->input->post('username'))
		{
                       
			$data = array(
                                        'username' => $this->input->post('username'),
                                        'password' => $this->input->post('password'),
                                        'fname' => $this->input->post('fname'),
                                        'lname' => $this->input->post('lname'),
                                        'email_id' => $this->input->post('email'),
                                        'type' => $this->input->post('type'),
                                        'photo' => $this->input->post('photo'),
                                        'status' => $this->input->post('status')						
					 );
			//$data['departments']=$this->department_model->department_lists();		 
			$result_user = $this->user_database->add_userlist($data); 
			if($result_user != 2)
			{
                            
				$result = $this->user_database->userlist_info();
				//print_r($result);
				$data = array(
						'userdata' => $result,
						
					);
				
				$this->load->view('user_list',$data);
			}
			else
			{
				$data = array(
			'error_message' => 'Username is already exist, Please try other username.'
			);
				$this->load->view('add_user',$data);
			}
				
		}
		else
		{	
		
			$this->load->view('add_user',$data);
		}
				
	}
	
	
	// Edit user	
	public function edit_user()
	{
		 //echo "in--"; die;
		if($this->input->post('username'))
		{
			
			
			$data = array(
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'fname' => $this->input->post('fname'),
						'lname' => $this->input->post('lname'),
						'email_id' => $this->input->post('email'),
						'type' => $this->input->post('type'),
						'photo' => $this->input->post('photo'),
						'status' => $this->input->post('status'),
						'userid' => $this->input->post('userid'),
					 );
					 
			$result_user = $this->user_database->edit_userlist($data);
			
			if($result_user == 2)
			{
				$result = $this->user_database->userlist_info();
				//print_r($result);
				$data = array(
						'userdata' => $result,
						
					);
				
				echo '<script>alert("Records has been modified successfully.");</script>';
				$this->load->view('user_list',$data);
			}
			else
			{
					/* $data = array(
						'success_message' => 'Records has been modified successfully.'
					);
					$this->load->view('edit_user',$success_message); */
					//echo '<script>alert("Records has been modified successfully.");</script>';
			}
				
		}
		else
		{	
			
			$usid = $_GET['uid'];		
			$this->load->model('user_database');
			$result_records = $this->user_database->userlist_info_data($usid); 
			//echo "<pre>";
			//print_r($result_records); 
			//die;
			 $data = array(
					'userrecord' => $result_records,
					
				); 
			
			$this->load->view('edit_user',$data);
		}
				
	}
	
	// Logout from admin page
	public function delete_user() {

		$usid = $_GET['uid'];
		$result_records = $this->user_database->delete_user_data($usid);
		if($result_records ==1)
		{
			$result = $this->user_database->userlist_info();				
			$data = array(
						'userdata' => $result,
						
					);
				
			$this->load->view('user_list',$data);
		}
	}

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */