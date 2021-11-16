<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class Notification extends DB
{
    private $table = "notifications";
    private $table_course = "courses";
    private $id_column = "notification_id";
    private $id_course_column = "course_id";
    private $id_lesson_column = "lesson_id";
    private $id_user_column = "user_id";

    public function get(int $id = 0)
    {
        if ($id != 0) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id";
        } else {
            $sql = "SELECT * FROM {$this->table}";
        }
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_user(int $user_id = 0)
    {
        if (empty($user_id)) {
            return [];
        }

        $sql = "SELECT notification_id, N.course_id, N.lesson_id, N.description, C.title AS course_title, C.slug AS course_slug, C.featured_image AS course_featured_image, N.published_at, seen FROM {$this->table} N LEFT JOIN {$this->table_course} C ON C.course_id = N.course_id WHERE N.{$this->id_user_column} = $user_id ORDER BY notification_id DESC";
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
        $course_id = empty($course_id) ? 'NULL' : $course_id;
        $lesson_id = empty($lesson_id) ? 'NULL' : $lesson_id;
        $sql = "INSERT INTO {$this->table} (description, user_id, course_id, lesson_id) VALUES(\"$description\", $user_id, $course_id, $lesson_id)";
        $result = $this->execute_query($sql);
        return $result;
    }

    public function switch_notification_status($notification_id = 0, $seen = 1)
    {
        if (empty($notification_id)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET seen = $seen WHERE {$this->id_column} = $notification_id";
        $result = $this->execute_query($sql);
        return $result;
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
