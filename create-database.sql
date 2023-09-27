
CREATE TABLE machines (
    machine_id INT PRIMARY KEY,
    machine_status ENUM('Available', 'Occupied', 'Maintenance') NOT NULL
);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL
);

CREATE TABLE bookings (
    booking_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    machine_id INT,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (machine_id) REFERENCES machines(machine_id)
);

-- Add some test data
INSERT INTO machines (machine_id, machine_status) VALUES
    (1, 'Available'),
    (2, 'Available'),
    (3, 'Available'),
    (4, 'Available'),
    (5, 'Available'),
    (6, 'Available'),
    (7, 'Available'),
    (8, 'Available'),
    (9, 'Available'),
    (10, 'Available');

INSERT INTO users (username) VALUES
    ('user1'),
    ('user2'),
    ('user3'),
    ('user4'),
    ('user5'),
    ('user6'),
    ('user7');

INSERT INTO bookings (user_id, machine_id, booking_date, booking_time) VALUES
    (1, 3, '2023-08-25', '12:00:00');
