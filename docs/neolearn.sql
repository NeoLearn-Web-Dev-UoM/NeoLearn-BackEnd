-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 08:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neolearn`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(6000) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `description`, `instructor_id`, `video_url`) VALUES
(6, 'Java', 'Lay a solid foundation in the world of programming with Java Fundamentals. This course is a comprehensive introduction to Java, covering key concepts such as syntax, object-oriented programming, data structures, and algorithms. Gain hands-on experience in writing Java code, understand the principles of application development, and prepare yourself for a wide range of software engineering tasks using this versatile and widely-used programming language.', 3, 'https://www.youtube.com/embed/drQK8ciCAjY?si=9bTHSMDP8yReFzvI&amp;controls=1https://www.youtube.com/embed/-uLbDzLIbZA'),
(7, 'Front End Development with React', 'Immerse yourself in the dynamic world of front-end development with React. This course is designed to take you from the fundamentals to advanced concepts in building user interfaces using the popular JavaScript library, React. Learn to create interactive and efficient web applications, understand the component-based architecture, and harness the power of React to deliver seamless user experiences.', 1, 'https://www.youtube.com/embed/drQK8ciCAjY?si=9bTHSMDP8yReFzvI&amp;controls=1https://www.youtube.com/embed/-uLbDzLIbZA'),
(10, 'Advanced CSS and JS Tricks to Master Front End Development', 'Elevate your front-end development prowess with this advanced course in CSS and JavaScript tricks. Uncover the secrets of crafting visually stunning and highly interactive user interfaces. From intricate animations to responsive layouts, learn the art of pushing the boundaries of front-end development to create captivating web experiences.', 3, 'https://www.youtube.com/embed/drQK8ciCAjY?si=9bTHSMDP8yReFzvI&amp;controls=1https://www.youtube.com/embed/-uLbDzLIbZA');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`id`, `name`, `email`, `password`) VALUES
(1, 'john doe', 'user5@teacher.com', '$2y$10$nWUNmRIBqKGdg5rtKKMDeeUzJZh437xqvTQ1Jus7aVK.y/0MWJ5te'),
(3, '', 'new@teacher.gr', '$2y$10$mLxS.PclWbJrY3RT86hQ..kW/jmuzajVMJk6sTciZ3LetJ0QEboq.');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `password`) VALUES
(1, 'Jason Tade', 'user12@test.gr', '$2y$10$uXPqAh6eus91LTQ9uikiNek/tDI2hUvsWaBJIVJvN4LlhSVCku.G2'),
(2, 'ArchJoey', 'new@student.gr', '$2y$10$uUaRTh2YhJVR.wFKdQYgNO5jrpGLM4cv/PXxr2gpHUTXmRAubrsii'),
(3, 'sahdgjash', 'user3@test.gr', '$2y$10$uQCikm.QZq9SG4gPwRIhc.POICWXdtS3Kd.RSmqwTNdN4BDujTmUa'),
(4, 'aaaaa', 'new2@student.gr', '$2y$10$l.RpSL5jgLrw8SaMlj3REuDakle1FwjLV.9D9swC5tXPQZI1Z9VxG');

-- --------------------------------------------------------

--
-- Table structure for table `student_has_courses`
--

CREATE TABLE `student_has_courses` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_has_courses`
--
ALTER TABLE `student_has_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_has_courses`
--
ALTER TABLE `student_has_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`);

--
-- Constraints for table `student_has_courses`
--
ALTER TABLE `student_has_courses`
  ADD CONSTRAINT `student_has_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `student_has_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
