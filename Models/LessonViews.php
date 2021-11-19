<?php
namespace Model;

use Model\Helper\DB;

/**
 *
 */

class LessonViews extends DB
{
    private $table = "lesson_views";
    private $table_user = "users";
    private $table_section = "sections";
    private $table_lesson = "lessons";
    private $table_course_user = "course_users";
    private $id_column = "lesson_view_id";
    private $lesson_column = "lesson_id";
    private $user_column = "user_id";

    public function get($lesson_id = 0, $user_id = 0)
    {
        if (empty($lesson_id) || empty($user_id)) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$this->lesson_column} = $lesson_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_lessons_views_students($course_id, $lesson_id)
    {
        if (empty($course_id)) {
            return [];
        }

        $sql = "SELECT DISTINCT LV.user_id, video_time, video_view, zoom_view, completed, LV.lesson_id, LV.user_id, LV.registered_at, email,  CONCAT(U.first_name, ' ', U.last_name) AS full_name FROM {$this->table} LV INNER JOIN {$this->table_user} U ON U.user_id = LV.user_id INNER JOIN {$this->table_course_user} CU ON CU.user_id = LV.user_id WHERE LV.{$this->lesson_column} = $lesson_id AND CU.course_id = $course_id AND CU.user_rol IN ('estudiante', 'residente')";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function is_completed($lesson_id = 0, $user_id = 0)
    {
        if (empty($lesson_id) || empty($user_id)) {
            return [];
        }

        $sql = "SELECT completed FROM {$this->table}
		WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        $result = $this->execute_query($sql);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        if (empty($arr[0]) || !$arr[0]['completed']) {
            return false;
        }

        return true;
    }

    public function update_view($lesson_id = 0, $user_id = 0, $data = [], $return_id = 0)
    {
        if (empty($data) or empty($user_id) or empty($lesson_id)) {
            return false;
        }

        extract($data);
        $sql = "SELECT zoom_view, video_view, completed FROM {$this->table} WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        $result = $this->execute_query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        if (empty($rows[0])) {
            $sql = "INSERT INTO {$this->table} (video_view, zoom_view, completed, lesson_id, user_id) VALUES($video_view, $zoom_view, 1, $lesson_id, $user_id)";
        } else {
            if ($rows[0]['completed']) {
                return true;
            }

            $sql = "UPDATE {$this->table} SET video_view = $video_view, zoom_view = $zoom_view WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        }
        if ($return_id) {
            $result = $this->execute_query_return_id($sql);
        } else {
            $result = $this->execute_query($sql);
        }
        return $result;
    }

    public function update_quiz_view($lesson_id = 0, $user_id = 0, $data = [], $return_id = 0)
    {
        if (empty($data) or empty($user_id) or empty($lesson_id)) {
            return false;
        }

        extract($data);
        $sql = "SELECT lesson_view_id, zoom_view, video_view, completed FROM {$this->table} WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        $result = $this->execute_query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        if (empty($rows[0])) {
            $sql = "INSERT INTO {$this->table} (video_view, zoom_view, completed, lesson_id, user_id) VALUES($video_view, $zoom_view, 1, $lesson_id, $user_id)";
        } else {
            if ($rows[0]['completed']) {
                return $rows[0]['lesson_view_id'];
            }

            $sql = "UPDATE {$this->table} SET video_view = $video_view, zoom_view = $zoom_view WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        }
        if ($return_id) {
            $result = $this->execute_query_return_id($sql);
        } else {
            $result = $this->execute_query($sql);
        }
        return $result;
    }

    public function update_video_view($lesson_id = 0, $user_id = 0, $data = [])
    {
        if (empty($data) or empty($user_id) or empty($lesson_id)) {
            return false;
        }

        extract($data);
        $sql = "SELECT video_view, completed FROM {$this->table} WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        $result = $this->execute_query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        if (empty($rows[0])) {
            $sql = "INSERT INTO {$this->table} (video_view, video_time, completed, lesson_id, user_id) VALUES($video_view, $video_time, $completed,$lesson_id, $user_id)";
        } else {
            if ($rows[0]['completed']) {
                return true;
            }

            $sql = "UPDATE {$this->table} SET video_view = 1, video_time = $video_time, completed = $completed WHERE {$this->lesson_column} = $lesson_id AND {$this->user_column} = $user_id";
        }
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
