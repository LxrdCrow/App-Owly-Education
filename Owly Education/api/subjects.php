<?php

header("Content-Type: application/json;");
include_once '../config/database.php';

$database = new Database ();
$db = $database->getConnection();

// HTTP method handling
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // create subject
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->name)) {
            $query = "INSERT INTO subjects (name) VALUES (:name)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(' :name', htmlspecialchars(strip_tags($data->name)));

            if($stmt->execute()) {
                echo json_encode(["message" => "Subject created successfully."]);
            } else {
                echo json_encode(["message" => "Subject could not be created."]);
            }
        } else {
            echo json_encode(["message" => "Incomplete data."]);
        }
        break;

        case 'PUT':
            // update subject
            $data = json_decode(file_get_contents("php://input"));
            if(!empty($data->id) && !empty($data->name)) {
                $query = "UPDATE subjects SET name = :name WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(' :name', htmlspecialchars(strip_tags($data->name)));
                $stmt->bindParam(' :id', htmlspecialchars(strip_tags($data->id)));

                if($stmt->execute()) {
                    echo json_encode(["message" => "Subject updated successfully."]);
                } else {
                    echo json_encode(["message" => "Subject could not be updated."]);
                }
            } else {
                echo json_encode(["message" => "Incomplete data."]);
            }
            break;

            case 'DELETE':
                //delete subject
                $data = json_decode(file_get_contents("php://input"));
                if(!empty($data->id)) {
                    $query = "DELETE FROM subjects WHERE id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':id', htmlspecialchars(strip_tags($data->id)));
        
                    if($stmt->execute()) {
                        echo json_encode(["message" => "Subject deleted successfully."]);
                    } else {
                        echo json_encode(["message" => "Unable to delete subject."]);
                    }
                } else {
                    echo json_encode(["message" => "Incomplete data."]);
                }
                break;
        
            default:
                echo json_encode(["message" => "Invalid request method."]);
                break;
        }


?>