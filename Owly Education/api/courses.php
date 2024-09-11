<?php

header("Content-Type: application/json");
include_once '../config/database.php';

$database = new Database ();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // create new course
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->name) && !empty ($data->available_slots) && !empty ($data->subjects)) {
            $db->beginTransaction();
            try {
                $query = "INSERT INTO courses (name, available_slots) VALUES (:name, :available_slots)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':name', htmlspecialchars(strip_tags($data->name)));
                $stmt->bindParam(':available_slots', $data->available_slots);
                $stmt->execute();

                $course_id = $db->lastInsertId();

                foreach ($data->subjects as $subject_id) {
                    $query = "INSERT INTO course_subject (course_id, subject_id) VALUES (:course_id, :subject_id)";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':course_id', $course_id);
                    $stmt->bindParam(':subject_id', $subject_id);
                    $stmt->execute();
                }

                $db->commit();
                echo json_encode(["message" => "Course created successfully."]);
            } catch (Exception $e) {
                $db->rollBack();
                echo json_encode(["message" => "Unable to update course.", "error" => $e->getMessage()]);
            }

        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

        case 'PUT':
            // update course
            $data = json_decode(file_get_contents("php://input"));
            if(!empty($data->id) && !empty($data->name) && !empty($data->available_slots) && !empty($data->subjects)) {
                $db->beginTransaction();
                try {
                    $query = "UPDATE courses SET name = :name, available_slots = :available_slots WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':name', htmlspecialchars(strip_tags($data->name)));
                    $stmt->bindParam(':available_slots', $data->available_slots);
                    $stmt->bindParam(':id', htmlspecialchars(strip_tags($data->id)));
                    $stmt->execute();

                    $query = "DELETE FROM course_subject WHERE course_id = :course_id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':course_id', $data->id);
                    $stmt->execute();

                    foreach ($data->subjects as $subject_id) {
                        $query = "INSERT INTO course_subject (course_id, subject_id) VALUES (:course_id, :subject_id)";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(':course_id', $data->id);
                        $stmt->bindParam(':subject_id', $subject_id);
                        $stmt->execute();
                    }

                    $db->commit();
                    echo json_encode(["message" => "Course updated successfully."]);
                } catch (Exception $e) {
                    $db->rollBack();
                    echo json_encode(["message" => "Unable to update course.", "error" => $e->getMessage()]);
                }

            } else {
                echo json_encode(["message" => "Incomplete data."]);
            }
            break;

            case 'DELETE':
                //delete course
                $data = json_decode(file_get_contents("php://input"));
                if(!empty($data->id)) {
                    $query = "DELETE FROM courses WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':id', htmlspecialchars(strip_tags($data->id)));

                    if($stmt->execute()) {
                        echo json_encode(["message" => "Course deleted successfully."]);
                    } else {
                        echo json_encode(["message" => "Unable to delete course."]);
                    }
                } else {
                    echo json_encode(["message" => "Incomplete data."]);
                }
                break;

                case 'GET':
                    // visualize and filter courses
                    $query = "SELECT c.id, c.name, c.available_slots, GROUP_CONCAT(s.name SEPARATOR ', ') as subjects 
                    FROM courses c 
                    LEFT JOIN course_subject cs ON c.id = cs.course_id 
                    LEFT JOIN subjects s ON cs.subject_id = s.id";

                    $conditions = [];
                    if (!empty($_GET['name'])) {
                        $conditions[] = "c.name LIKE :name";
                    }
                    if (!empty($_GET['subject'])) {
                        $conditions[] = "s.name LIKE :subject";
                    }
                    if (!empty($_GET['available_slots'])) {
                        $conditions[] = "c.available_slots = :available_slots";
                    }
                    if  (count($conditions) > 0) {
                        $query .= " WHERE " . implode(" AND ", $conditions);
                    }
                    
                    $query .= " GROUP BY c.id";

                    $stmt = $db->prepare($query);

                    if (!empty($_GET['name'])) {
                        $stmt->bindParam(':name', $name);
                        $name = '%' . $_GET['name'] . '%';
                    }
                    if (!empty($_GET['subject'])) {
                        $stmt->bindParam(':subject', $subject);
                        $subject = '%' . $_GET['subject'] . '%';
                    }
                    if (!empty($_GET['available_slots'])) {
                        $stmt->bindParam(':available_slots', $_GET['available_slots']);
                    }

                    $stmt->execute();
                    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    echo json_encode($courses);
                    break;

                    default:
                    echo json_encode(["message" => "Invalid request method."]);
                    break;
    }





        










?>