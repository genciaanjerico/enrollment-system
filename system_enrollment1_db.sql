SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



-- Database: `system_enrollment1_db`






CREATE TABLE `student_info` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gender` varchar (50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `student_enroll` (
  `student_id` int(11) NOT NULL,
  `student_type` varchar(59) DEFAULT NULL,
  `student_course` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE course_summary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_course VARCHAR(200) NOT NULL,
    student_count INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `deleted_student_info` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `deleted_student_enroll` (
  `student_id` int(11) NOT NULL,
  `student_type` varchar(59) DEFAULT NULL,
  `student_course` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `audit_student_info` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `audit_student_enroll` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `student_type` varchar(59) DEFAULT NULL,
  `student_course` varchar(200) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);



DROP TABLE IF EXISTS `students`;


ALTER TABLE `student_info`
  ADD PRIMARY KEY (`student_id`);


ALTER TABLE `student_info`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;






CREATE VIEW all_student_info AS
  SELECT student_info.student_id, student_info.first_name, student_info.middle_name, student_info.last_name, student_info.gender, student_info.dob, student_info.address, 
  student_enroll.student_type, student_enroll.student_course, student_enroll.created_at, student_enroll.updated_at FROM student_info JOIN student_enroll ON student_enroll.student_id = student_info.student_id;

CREATE VIEW `view_deleted_students` AS
SELECT
    dsi.`student_id`,
    dsi.`first_name`,
    dsi.`middle_name`,
    dsi.`last_name`,
    dsi.`gender`,
    dsi.`dob`,
    dsi.`address`,
    dsi.`created_at` AS `deleted_info_at`,
    dse.`student_type`,
    dse.`student_course`,
    dse.`created_at` AS `deleted_enroll_at`
FROM `deleted_student_info` dsi
JOIN `deleted_student_enroll` dse ON dsi.`student_id` = dse.`student_id`;





DELIMITER //

CREATE PROCEDURE Insert_Student(
  IN p_student_type VARCHAR(59),
  IN p_first_name VARCHAR(50),
  IN p_middle_name VARCHAR(50),
  IN p_last_name VARCHAR(50),
  IN p_gender VARCHAR(50),
  IN p_dob DATE,
  IN p_address VARCHAR(200),
  IN p_student_course VARCHAR(200),
  IN p_student_no VARCHAR(255)
)
BEGIN
  DECLARE v_student_id INT;

  INSERT INTO student_info (
    first_name,
    middle_name,
    last_name,
    gender,
    dob,
    address,
    created_at,
    updated_at
  ) VALUES (
    p_first_name,
    p_middle_name,
    p_last_name,
    p_gender,
    p_dob,
    p_address,
    CURRENT_TIMESTAMP(),
    CURRENT_TIMESTAMP()
  );

  SET v_student_id = LAST_INSERT_ID();

  INSERT INTO student_enroll (
    student_id,
    student_type,
    student_course,
    created_at,
    updated_at
  ) VALUES (
    v_student_id,
    p_student_type,
    p_student_course,
    CURRENT_TIMESTAMP(),
    CURRENT_TIMESTAMP()
  );
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE GetStudentInfo()
BEGIN
    SELECT
        si.student_id,
        si.first_name,
        si.middle_name,
        si.last_name,
        si.gender,
        si.dob,
        si.address,
        se.student_type,
        se.student_course,
        si.created_at,
        si.updated_at
    FROM
        student_info si
    INNER JOIN
        student_enroll se ON si.student_id = se.student_id;
END //

DELIMITER ;


DELIMITER //
CREATE TRIGGER before_delete_student_info
BEFORE DELETE ON student_info
FOR EACH ROW
BEGIN
    INSERT INTO deleted_student_info (student_id, first_name, middle_name, last_name, gender, dob, address, created_at, updated_at)
    VALUES (OLD.student_id, OLD.first_name, OLD.middle_name, OLD.last_name, OLD.gender, OLD.dob, OLD.address, OLD.created_at, OLD.updated_at);
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_delete_student_enroll
BEFORE DELETE ON student_enroll
FOR EACH ROW
BEGIN
    INSERT INTO deleted_student_enroll (student_id, student_type, student_course, created_at, updated_at)
    VALUES (OLD.student_id, OLD.student_type, OLD.student_course, OLD.created_at, OLD.updated_at);
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_update_student_info
AFTER UPDATE ON student_info
FOR EACH ROW
BEGIN
    INSERT INTO audit_student_info (student_id, first_name, middle_name, last_name, gender, dob, address, updated_at)
    VALUES (OLD.student_id, OLD.first_name, OLD.middle_name, OLD.last_name, OLD.gender, OLD.dob, OLD.address, NOW());
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_update_student_enroll
AFTER UPDATE ON student_enroll
FOR EACH ROW
BEGIN
    INSERT INTO audit_student_enroll (student_id, student_type, student_course, updated_at)
    VALUES (OLD.student_id, OLD.student_type, OLD.student_course, NOW());
END;
//
DELIMITER ;





SET GLOBAL event_scheduler = ON;

DELIMITER //

CREATE EVENT update_course_summary
ON SCHEDULE EVERY 1 MINUTE
DO
  BEGIN
    INSERT INTO course_summary (student_course, student_count)
    SELECT student_course, COUNT(*) FROM student_enroll GROUP BY student_course;
  END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE UpdateStudentInfo(
    IN p_student_id INT,
    IN p_first_name VARCHAR(50),
    IN p_middle_name VARCHAR(50),
    IN p_last_name VARCHAR(50),
    IN p_gender VARCHAR(50),
    IN p_dob DATE,
    IN p_address VARCHAR(200),
    IN p_student_type VARCHAR(59),
    IN p_student_course VARCHAR(200)
)
BEGIN
    UPDATE student_info
    SET
        first_name = p_first_name,
        middle_name = p_middle_name,
        last_name = p_last_name,
        gender = p_gender,
        dob = p_dob,
        address = p_address
    WHERE student_id = p_student_id;

    UPDATE student_enroll
    SET
        student_type = p_student_type,
        student_course = p_student_course
    WHERE student_id = p_student_id;
END //

DELIMITER ;



DELIMITER //

CREATE PROCEDURE DeleteStudent(
    IN p_student_id INT
)
BEGIN
    DELETE FROM student_info
    WHERE student_id = p_student_id;

    DELETE FROM student_enroll
    WHERE student_id = p_student_id;


    SELECT 'Deleted Successfully' AS message;
END //

DELIMITER ;



