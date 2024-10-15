<?php
require_once '../models/course.php';

class CourseController {
    private $course;

    public function __construct() {
        $this->course = new Course();
    }

    
    public function index() {
        $name = isset($_GET['name']) ? $_GET['name'] : null;
        $available_slots = isset($_GET['available_slots']) && is_numeric($_GET['available_slots']) ? $_GET['available_slots'] : null;
        $subject_ids = isset($_GET['subject_ids']) ? array_filter(explode(',', $_GET['subject_ids']), 'is_numeric') : null;
        $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? $_GET['limit'] : 10;  // Limite di default a 10
        $offset = isset($_GET['offset']) && is_numeric($_GET['offset']) ? $_GET['offset'] : 0;

        $courses = $this->course->getFilteredCourses($subject_ids, $name, $available_slots, $limit, $offset);

        echo json_encode($courses);
    }

    
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $subjects = $data['subjects'];
        $available_slots = $data['available_slots'];

        if ($this->course->createCourse($name, $subjects, $available_slots)) {
            echo json_encode(['message' => 'Create course successfully.']);
        } else {
            echo json_encode(['message' => 'Error creating course.']);
        }
    }

    
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $subjects = $data['subjects'];
        $available_slots = $data['available_slots'];

        if ($this->course->updateCourse($id, $name, $subjects, $available_slots)) {
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


