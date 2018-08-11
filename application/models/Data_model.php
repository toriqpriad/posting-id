<?php

class data_model extends CI_Model
{

    public function get($params)
    {

        if (isset($params->select_values)) {
            $select_values = $params->select_values;
        }

        $dest_table_as = $params->dest_table_as;

        if (isset($params->join_tables)) {
            $join_tables = $params->join_tables;
        }

        if (isset($params->like_where_tables)) {
            $where_tables = $params->like_where_tables;
        }

        if (isset($params->where_tables)) {
            $where_tables = $params->where_tables;
        }
        if (isset($params->where_tables_like)) {
            $where_tables_like = $params->where_tables_like;
        }
        if (isset($params->or_where_tables)) {
            $or_where_tables = $params->or_where_tables;
        }
        if (isset($params->where_in)) {
            $where_in = $params->where_in;
            // print_data($where_in);
        }
        if (isset($params->order_by)) {
            $order_by = $params->order_by;
        }

        if (isset($params->limit)) {
            $limit = $params->limit;
        }

        if (isset($params->pagination)) {
            $pagination = $params->pagination;
        }

        if (isset($params->group_by)) {
            $group_by = $params->group_by;
        }

        foreach ($select_values as $each_select) {
            $select[] = $this->db->select($each_select);
        }

        $from = $this->db->from($dest_table_as);

        if ((isset($join_tables))) {
            foreach ($join_tables as $each_join) {
                $join = $this->db->join($each_join['join_with'], $each_join['join_on'], $each_join['join_type']);
            }
        }
        if ((isset($where_tables))) {
            foreach ($where_tables as $each_where) {
                $where = $this->db->where($each_where['where_column'], $each_where['where_value']);
            }
        }

        if ((isset($where_tables_like))) {
            foreach ($where_tables_like as $each_where) {
                $where_like = $this->db->like($each_where['where_column'], $each_where['where_value']);
            }
        }

        if ((isset($where_in))) {
            foreach ($where_in as $each_where_in) {
                $where_in = $this->db->where_in($each_where_in['where_column'], $each_where_in['where_value']);
            }
        }

        if ((isset($or_where_tables))) {
            foreach ($or_where_tables as $each_where) {
                $or_where = $this->db->or_where($each_where['where_column'], $each_where['where_value']);
            }
        }

        if ((isset($group_by))) {
            $group_by = $this->db->group_by($group_by);
        }

        if ((isset($order_by))) {
            foreach ($order_by as $each_order_by) {
                $order = $this->db->order_by($each_order_by['order_column'], $each_order_by['order_type']);
            }
        }

        if ((isset($limit))) {
            $limit = $this->db->limit($limit);
        }

        if ((isset($pagination))) {
            //offset => how many datas allowed to get
            //start => start on array n
            $pagination = $this->db->limit($pagination['offset'], $pagination['start']);
        }

        $query = $this->db->get();
        $res   = $query->result();
        if ($query == true) {
            $response = OK_STATUS;
            $data     = array("response" => $response, "results" => $res, "sql" => $this->db->last_query());
            // $data = array("response" => $response, "results" => $res);
        } else {
            $response = FAIL_STATUS;
            $data     = array("response" => $response, "results" => $res);
        }
        return $data;
    }

    public function add($params, $dest_table)
    {

        /*
        This Function Parameter
        $params = array() for insert;
        $dest_table_as = 'table_name' for insert;
         */

        $query = $this->db->insert($dest_table, $params);
        if ($query == true) {
            $res      = $this->db->insert_id();
            $response = OK_STATUS;
            $data     = array("response" => $response, "data" => $res);
        } else {
            $response = FAIL_STATUS;
            $data     = array("response" => $response, "data" => "");
        }
        return $data;
    }

    public function update($params, $use_concat = null)
    {

        /*
        This Function Parameter
        $params = array() for update;
        $dest_table_as = 'table_name' for update;
         */        
        if ($use_concat == TRUE) {
            $query = $this->db->set($use_concat['destination'],"CONCAT(".$use_concat['concat_arg'].")", FALSE);
        } else {
            $query = $this->db->set($params->new_data);
        }

        foreach ($params->where_tables as $each_where) {
            $where = $this->db->where($each_where['where_column'], $each_where['where_value']);
        }
        $update = $this->db->update($params->table_update);
        if ($query == true) {
            $response = OK_STATUS;
            $data     = array("response" => $response);
            // $data = array("response" => "YES", "results" => $this->db->last_query());
        } else {
            $response = FAIL_STATUS;
            // $data = array("response" => $response, "results" => $this->db->last_query());
            $data = array("response" => $response);
        }
        return $data;
    }

    public function delete($params)
    {
        $where = $params->where_tables;
        $table = $params->table;
        if ((isset($where)) or $where != "") {
            foreach ($where as $each_where) {
                $where = $this->db->where($each_where['where_column'], $each_where['where_value']);
            }
        }
        $query = $this->db->delete($table);
        if ($query == true) {
            $response = OK_STATUS;
            // $data = array("response" => $response,"log" => $this->db->last_query());
            $data = array("response" => $response);
        } else {
            $response = FAIL_STATUS;
            $data     = array("response" => $response);
        }

        return $data;
    }

    public function get_count($table, $where = null)
    {
        if ((isset($where)) or $where != "") {
            foreach ($where as $each_where) {
                if ($each_where['type'] == 'IN') {
                    $where = $this->db->where_in($each_where['where_column'], $each_where['where_value']);
                } else if ($each_where['type'] == 'LIKE') {
                    $where_like = $this->db->like($each_where['where_column'], $each_where['where_value']);
                } else if ($each_where['type'] == 'OR') {
                    $or_where = $this->db->or_where($each_where['where_column'], $each_where['where_value']);
                } else {
                    $where = $this->db->where($each_where['where_column'], $each_where['where_value']);
                }
            }
        }
        $query = $this->db->count_all_results($table);
        if ($query == true) {
            $response = OK_STATUS;
            $data     = array("response" => $response, "results" => $query, "sql" => $this->db->last_query());
            // $data = array("response" => $response,"log" => $this->db->last_query());
        } else {
            $response = FAIL_STATUS;
            // $data = array("response" => $response,"log" => $this->db->last_query());
            $data = array("response" => $response, "results" => $query);
        }
        return $data;
    }

    public function delete_now($table = null, $column = null, $value = null)
    {
        try {
            $where = $this->db->where($column, $value);
            $query = $this->db->delete($table);
            if ($query == true) {
                $response = OK_STATUS;
                $message  = OK_MESSAGE;
            } else {
                $response = FAIL_STATUS;
                $message  = FAIL_MESSAGE;
            }
        } catch (Exception $e) {
            $response = FAIL_STATUS;
            $message  = FAIL_MESSAGE;
        }
        $data = array("response" => $response, "message" => $message);
        return $data;
    }

}
