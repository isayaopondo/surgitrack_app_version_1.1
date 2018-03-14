<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 14/03/2018
 * Time: 09:22
 */

class Utilities extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
            }

            public function update_table(){
                $fields = array(
                    'surgery_type' => array(
                        'type' => 'TINYINT',
                        'constraint' => '4',
                        'default' =>'2',
                    ),
                );
                $this->dbforge->add_column('strack_booking', $fields);
                //$this->dbforge->add_field($fields);
            }

}