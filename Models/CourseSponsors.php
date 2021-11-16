<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class CourseSponsors extends DB
{
    private $table = "course_sponsors";
    private $table_course = "courses";
    private $table_sponsors = "sponsors";
    private $id_column = "course_sponsor_id";
    private $id_course_column = "course_id";

    public function get(int $id = 0)
    {
        if ($id != 0) {
            $sql = "SELECT course_sponsor_id, S.sponsor_id, sponsor_name, logo_url, website FROM {$this->table} CS INNER JOIN {$this->table_course} C ON CS.course_id = C.course_id INNER JOIN {$this->table_sponsors} S ON CS.sponsor_id = S.sponsor_id WHERE C.{$this->id_course_column} = $id";
        } else {
            $sql = "SELECT course_sponsor_id, S.sponsor_id, sponsor_name, logo_url, website FROM {$this->table} CS INNER JOIN {$this->table_course} C ON CS.course_id = C.course_id INNER JOIN {$this->table_sponsors} S ON CS.sponsor_id = S.sponsor_id ";
        }
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
        $result = $this->execute_query($sql);
        return $result;
    }

}
