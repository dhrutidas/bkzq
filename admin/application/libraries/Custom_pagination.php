<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Shrikant Mavlankar
 * @date    13.05.2015
 * 
**/

class Custom_pagination {
 
    public function init_pagination( $uri, $total_rows, $per_page = 10, $segment = 4 ){
        
        $this->load->library('pagination');

        $config['per_page']         = $per_page;
        $config['uri_segment']      = $segment;
        $config['base_url']         = base_url().$uri;
        $config['total_rows']       = $total_rows;
        $config['use_page_numbers'] = TRUE;
        $config['first_tag_open']   = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close']  = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['cur_tag_open']     = "<li class='active'><span><b>";
        $config['cur_tag_close']    = "</b></span></li>";
        
        $this->pagination->initialize($config);            
    }
}