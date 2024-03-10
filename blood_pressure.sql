
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `blood_pressure` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `systolic` int(11) NOT NULL,
  `diastolic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


ALTER TABLE `blood_pressure`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `blood_pressure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
