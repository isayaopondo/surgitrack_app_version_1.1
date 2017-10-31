<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Terminologies_model extends MY_Model{

    function __construct() {
        parent::__construct();
    }

    public function get_procedure_tree() {
        $arrayCategories = array();
        $this->db->select('*')
                ->from('strack_facility_procedure_groups'); //onclick="load_group_procedures(\'' . $row->group_id . '\')"
        $this->db->where(array('isdeleted' => '0'));
        $query = $this->db->get();
        $result = $query->result();

        if ($query->num_rows() > 0) {
            $r = "<ul role=\"group\">";
            foreach ($result as $row) {
                $r = $r . '<li role="treeitem" class="root" style="display: list-item;"  id="' . $row->group_id . '" data-bank-path="' . $row->group_name . '"><span><i class="fa fa-lg fa-plus-square"></i> ' . $row->group_name . '</span> ' . $this->get_subprocedure($row->group_id, $row->group_name) . "</li>";
            }
            $r = $r . "</ul>";
            return $r;
            //return $this->menubuilder($arrayCategories, '0', '_bank');
        }
    }

    public function get_subprocedure($id, $group_name) {
        $arrayCategories = array();
        $this->db->select('*')
                ->from('strack_facility_procedure_subgroups');
        $this->db->where('group_id', $id);
        $this->db->where(array('isdeleted' => '0', 'group_id' => $id));
        $query = $this->db->get();
        $result = $query->result();

        if ($query->num_rows() > 0) {
            $r = "<ul role=\"group\">";
            foreach ($result as $row) {
                $r = $r . '<li class="has_items" style="display: list-item;" onclick="load_subgroup_procedures(\'' . $row->subgroup_id . '\')" id="' . $id . '_' . $row->subgroup_id . '" data-bank-path="' . $group_name . '/' . $row->subgroup_name . '"><span><i class="fa fa-lg fa-list"></i> </span> ' . $row->subgroup_name . "</li>";
            }
            $r = $r . "</ul>";
            return $r;
        }
    }

    function menubuilder($a, $level, $option) {

        if (!is_null($a)) {
            $r = "<ul>";
            foreach ($a as $i) {
                if ($i['parent_id'] == $level) {
                    $classchild = ($i['is_child'] === "1" && $i['has_items'] === "0") ? ' root ' : '';
                    $classicon = $i['has_items'] === "1" ? ' fa-list' : (($i['is_child'] == "1") ? ' fa-folder' : 'fa-folder-open');
                    $iconsize = $i['is_child'] === "0" ? ' fa-lg ' : '';
                    $classhasitems = $i['has_items'] === "1" ? 'context-menu-one' . $option . ' bank_leaf ' : 'context-root' . $option . ' bank_branch ';
                    $isroot = $i['is_child'] === "0" ? 'disable' : $classhasitems;
                    $r = $r . '<li class="' . $isroot . $classchild . '" id="' . $i['bank_id'] . '" data-bank-path="' . $i['bank_path'] . '"><span><i class="fa ' . $iconsize . $classicon . '"></i> ' . $i['bank_name'] . '</span>' . $this->menubuilder($a, $i['bank_id'], $option) . "</li>";
                }
            }
            $r = $r . "</ul>";
            return $r;
        }
    }

}
