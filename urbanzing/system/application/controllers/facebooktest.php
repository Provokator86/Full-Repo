<?
class Facebooktest extends Controller{
        function Facebooktest(){
                parent::Controller();
                $this->load->model('facebook_model');
        }
        
        function index(){
                $this->load->view('facebooktest/index');
        }

        function test1(){
                $data = array();
                $data['user'] = $this->facebook_model->getUser();
                $this->load->view('facebooktest/test1',$data);
        }
}


