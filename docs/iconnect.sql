CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nickname VARCHAR(100),
  department VARCHAR(100),
  languages_spoken VARCHAR(255),
  hobbies VARCHAR(255),
  self_intro TEXT,
  picture VARCHAR(255),
  gender TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE friends (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,
    friend_id INT NOT NULL,

    status ENUM('accepted', 'pending', 'blocked') DEFAULT 'accepted',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_friend_pair (user_id, friend_id),

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (friend_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE chat_rooms (
    id CHAR(36) PRIMARY KEY,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_pair (user1_id, user2_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;