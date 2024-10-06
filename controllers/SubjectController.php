<?php
require_once '../models/subject.php';

class SubjectController {
    private $subjectModel;

    public function __construct() {
        $this->subjectModel = new Subject();
    }

    
    public function index() {
        $subjects = $this->subjectModel->getAllSubjects();
        echo json_encode($subjects);
    }

    
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['name'])) {
            $name = $data['name'];

            if ($this->subjectModel->createSubject($name)) {
                echo json_encode(['message' => 'Subject created successfully']);
            } else {
                echo json_encode(['message' => 'Failed to create subject']);
            }
        } else {
            echo json_encode(['message' => 'Invalid input']);
        }
    }

    
    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['name'])) {
            $name = $data['name'];

            if ($this->subjectModel->updateSubject($id, $name)) {
                echo json_encode(['message' => 'Subject updated successfully']);
            } else {
                echo json_encode(['message' => 'Failed to update subject']);
            }
        } else {
            echo json_encode(['message' => 'Invalid input']);
        }
    }

    
    public function destroy($id) {
        if ($this->subjectModel->deleteSubject($id)) {
            echo json_encode(['message' => 'Subject deleted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to delete subject']);
        }
    }
}
?>

