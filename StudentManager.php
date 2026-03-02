<?php
// StudentManager.php

class StudentManager {
  private mysqli $conn;

  public function __construct(mysqli $conn) {
    $this->conn = $conn;
  }

  public function getAllStudents() {
    $sql = "SELECT id, id_number, full_name, email, course
            FROM students
            ORDER BY id DESC";
    return $this->conn->query($sql);
  }

  public function getStudentById(int $id): ?array {
    $sql = "SELECT id, id_number, full_name, email, course
            FROM students
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();
    return $row ?: null;
  }

  public function createStudent(string $idNumber, string $fullName, string $email, string $course): bool {
    $sql = "INSERT INTO students (id_number, full_name, email, course)
            VALUES (?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssss", $idNumber, $fullName, $email, $course);

    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
  }

  public function updateStudent(int $id, string $idNumber, string $fullName, string $email, string $course): bool {
    $sql = "UPDATE students
            SET id_number = ?, full_name = ?, email = ?, course = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssssi", $idNumber, $fullName, $email, $course, $id);

    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
  }

  public function deleteStudent(int $id): bool {
    $sql = "DELETE FROM students WHERE id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
  }
}