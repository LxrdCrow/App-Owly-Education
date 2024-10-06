<?php
require_once '../models/course.php';

class CourseController {
    private $course;

    public function __construct() {
        $this->course = new Course();
    }

    public function index() {
        $courses = $this->course->getAllCourses();
        echo json_encode($courses);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $subjects = $data['subjects'];
        $seats = $data['seats'];

        if ($this->course->createCourse($name, $subjects, $seats)) {
            echo json_encode(['message' => 'Create course successfully.']);
        } else {
            echo json_encode(['message' => 'Error creating course.']);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $subjects = $data['subjects'];
        $seats = $data['seats'];

        if ($this->course->updateCourse($id, $name, $subjects, $seats)) {
            echo json_encode(['message' => 'Course updated successfully.']);
        } else {
            echo json_encode(['message' => 'Error updating course.']);
        }
    }

    public function destroy($id) {
        if ($this->course->deleteCourse($id)) {
            echo json_encode(['message' => 'Delete course successfully.']);
        } else {
            echo json_encode(['message' => 'Error deleting course.']);
        }
    }
}
?>

