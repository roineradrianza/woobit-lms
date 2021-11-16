<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class CourseRating extends DB
{
    private $table = "course_ratings";
    private $table_user = "users";
    private $id_column = "course_rating_id";
    private $id_course_column = "course_id";
    private $id_user_column = "user_id";

    public function get($id = 0)
    {
        if ($id == 0) {
            return false;
        }
        $extra = !empty($_SESSION['user_id']) ? "AND CR.user_id NOT IN ({$_SESSION['user_id']})" : '';
        $sql = "SELECT course_rating_id, stars, comment, published_at, CR.user_id, first_name, last_name, avatar
        FROM {$this->table} CR INNER JOIN {$this->table_user} U ON U.user_id = CR.user_id WHERE {$this->id_course_column} = $id $extra ORDER BY published_at DESC";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_user_and_course($course_id = 0, $user_id = 0)
    {
        if (empty($course_id) || empty($user_id)) {
            return false;
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->id_course_column} = $course_id AND {$this->id_user_column} = $user_id LIMIT 1";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function create($data = [])
    {
        if (empty($data)) {
            return false;
        }

        extract($data);
        $sql = "INSERT INTO {$this->table} (comment, stars, course_id, user_id) VALUES('$comment', $stars, $course_id, $user_id)";
        $result = $this->execute_query_return_id($sql);
        return $result;
    }

    public function edit($data = [])
    {
        if (empty($data) or empty($data['user_id'])) {
            return false;
        }

        extract($data);
        $sql = "UPDATE {$this->table} SET comment = '$comment', stars = $stars
        WHERE {$this->id_course_column} = {$data['course_id']} AND {$this->id_user_column} = {$data['user_id']}";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id";
        $result = $this->execute_query($sql);
        return $result;
    }

}
